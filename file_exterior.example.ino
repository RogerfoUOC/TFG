/* LLIBRERIES */
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClientSecureBearSSL.h>
#include <Wire.h>
#include <Adafruit_Sensor.h>
#include <Adafruit_BME280.h>

/* DEFINICIÓ DE XARXES WI-FI
   Permet millorar la robustesa del sistema en
   entorns amb múltiples punts d’accés disponibles. */
struct WifiCredentials {
  const char* ssid;
  const char* password;
};

const WifiCredentials networks[] = {
  {"WIFI1", "++++++++"},
  {"WIFI2", "++++++++"},
  {"WIFI3", "++++++++"},
  {"WIFI4", "++++++++"}
};

const int NUM_NETWORKS = sizeof(networks) / sizeof(networks[0]);

/* CONFIGURACIÓ DE COMUNICACIÓ AMB EL SERVIDOR
   Identifica el dispositiu i valida l’origen de dades. */
const char* serverName = "https://rogerfo.link/tfg/receptor-dades.php";

const String apiKey = "++++++++";
const String sensorName = "BME280E";
const String sensorLocation = "Exterior";

/* SENSOR BME280
   Utilitzat per obtenir temperatura, humitat i pressió
   mitjançant comunicació I2C. */
Adafruit_BME280 bme;

/* FUNCIÓ DE CONNEXIÓ WI-FI
   Intenta connectar-se seqüencialment a les xarxes
   definides i evita bloquejos prolongats. */
void connectWifi() {
  WiFi.mode(WIFI_STA); 

  for (int i = 0; i < NUM_NETWORKS; i++) {
    WiFi.begin(networks[i].ssid, networks[i].password);

    int attempts = 0;
    while (WiFi.status() != WL_CONNECTED && attempts < 150) {
      delay(100);
      attempts++;
    }

    if (WiFi.status() == WL_CONNECTED) {
      return; // connexió OK
    }

    WiFi.disconnect(); // neteja d’estat abans del següent intent
    delay(1000);
  }
}

/* SETUP
   Inicialitza comunicacions, connectivitat i sensor.
   Atura l’execució si el sensor no està disponible. */
void setup() {
  Serial.begin(9600);
  delay(1000);
  Serial.println("\n--- Iniciant sistema ---");

  // FORÇA ELS PINS I2C: D2 per a dades (SDA) i D1 per al rellotge (SCL)
  // En moltes plaques NodeMCU/Wemos, aquests són els pins estàndard.
  Wire.begin(4, 5); // 4 és el GPIO4 (D2) i 5 és el GPIO5 (D1)

  connectWifi(); 

  // Prova amb l'adreça 0x76 i, si falla, intenta 0x77
  if (!bme.begin(0x76)) {
    Serial.println("No trobat a 0x76, provant a 0x77...");
    if (!bme.begin(0x77)) {
      Serial.println("ERROR: No s'ha trobat el sensor BME280 a cap adreça!");
      while (1) { delay(5000); Serial.println("Esperant sensor..."); }
    }
  }
  Serial.println("Sensor BME280 configurat correctament.");
}

/* LOOP PRINCIPAL
   Controla la connectivitat, llegeix el sensor i
   envia les dades al servidor.  */
void loop() {

  /* Comprovació de connexió */
  if (WiFi.status() != WL_CONNECTED) {
    connectWifi();
    if (WiFi.status() != WL_CONNECTED) {
      delay(5000);
      return; // Evita enviar dades sense connexió
    }
  }

  /* Creació de client HTTPS */
  std::unique_ptr<BearSSL::WiFiClientSecure> client(new BearSSL::WiFiClientSecure);
  client->setInsecure();

  HTTPClient https;
  https.begin(*client, serverName);
  https.addHeader("Content-Type", "application/x-www-form-urlencoded");

  /* Construcció HTTP amb les dades del sensori la API necessària pel processament al servidor */
  String postData =
    "api_key=" + apiKey +
    "&sensor=" + sensorName +
    "&location=" + sensorLocation +
    "&value1=" + String(bme.readTemperature()) +
    "&value2=" + String(bme.readHumidity()) +
    "&value3=" + String(bme.readPressure() / 100.0F);

  https.POST(postData); // Enviament de dades via HTTP 
  https.end();          

  /* Interval d’enviament de dades */
  delay(600000); // 10 minuts
}