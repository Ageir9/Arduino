#include "dht.h"
dht DHT;
#define DHT22_PIN 9


int CO_analogPin = A0;
int limit;
int co_value;

void setup()
{
  pinMode(4, OUTPUT);
  pinMode(7, OUTPUT);
  
  tone(8,1047,350);
  delay(200);
  tone(8,1319,350); 
  delay(200);
  tone(8,1568,350);
  delay(200);
    
  Serial.begin(9600);
  Serial.print("Made By Haskur");
  Serial.println();
  Serial.println("Humidity (%),\tTemperature (C),\tCO value (ppm)");
}

void loop()
{
  co_value = analogRead(CO_analogPin);  
  // READ DATA
  int chk = DHT.read22(DHT22_PIN);
  switch (chk)
  {
    case DHTLIB_OK:  
      Serial.print(""); 
      break;
    case DHTLIB_ERROR_CHECKSUM: 
      Serial.print("Checksum error,\t"); 
      break;
    case DHTLIB_ERROR_TIMEOUT: 
      Serial.print("Time out error,\t"); 
      break;
    default: 
      Serial.print("Unknown error,\t"); 
      break;
  }
  // DISPLAY DATA
  Serial.print(DHT.humidity,1);
  Serial.print("\t\t");
  Serial.print(DHT.temperature,1);
  Serial.print("\t\t\t");
  Serial.println(co_value);
  
  if(DHT.temperature > 35)
    tone(8, 494, 500);
  if(DHT.humidity > 66 && DHT.temperature > 26)
    tone(8, 494, 500);
  if(DHT.humidity > 70)
    tone(8, 494, 500);
  if(co_value > 90)
    tone(8, 494, 500);
  
delay(1000);  
}
//End Loop

