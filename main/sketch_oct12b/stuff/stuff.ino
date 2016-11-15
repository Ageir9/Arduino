
#include "dht.h"
dht DHT;
#define DHT22_PIN 9


int CO_analogPin = A0;
int limit;
int co_value;
#include <SPI.h>
#include <Ethernet.h>

int mq3_analogPin = A0;


byte mac[] = {
  0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED
};
IPAddress ip(10,220,216,200);

EthernetServer server(80);

void setup() {
 
  Serial.begin(9600);
  while (!Serial) {
    ; 
  }

  Ethernet.begin(mac, ip);
  server.begin();
  //Serial.print("server is at ");
  //Serial.println(Ethernet.localIP());

//Mad Hacking Below

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
//Mad Hacking Done

}//end setup

void loop() {
  EthernetClient client = server.available();
  if (client) {
    Serial.println("new client");
 
    boolean currentLineIsBlank = true;
    while (client.connected()) {
      if (client.available()) {
        char c = client.read();
        Serial.write(c);

        if (c == '\n' && currentLineIsBlank) {
          
      
          
          client.println();
          client.println("<!DOCTYPE HTML>");
          client.println("<html>");
          // output the value of each analog input pin

            client.println("Humidity (%),\t\tTemperature (C),\t\tCO value (ppm)");
            client.println("<br>");
            while(true)
            {             
              client.print(DHT.humidity,1);
              client.print("\t\t\t\t\t");
              client.print(DHT.temperature,1);
              client.print("\t\t\t\t\t");
              client.print(co_value);
              client.print("Refresh: 5");  
              delay(3000);
            }       
            
        }
        if (c == '\n') {
          // you're starting a new line
          currentLineIsBlank = true;
        }
        else if (c != '\r') {
          // you've gotten a character on the current line
          currentLineIsBlank = false;
        }
      }
    }
    // give the web browser time to receive the data
    delay(1);
    // close the connection:
    client.stop();  //EF ALLT BROTNAR ÞÁ Á AÐ KOMMENTA ÞESSA LÍNU BURT!!!!!!!!!!!!!!!!!!!!!!!!!!! AAAAAAAAAAAAAA!!!!!!!!!!!!
    Serial.println("client disconnected");
  }
  //end while loop

 //More Mad Hacking Below
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
  // DISPLAY DATA IN MONITOR
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
  if(co_value > 100)
    tone(8, 494, 500);
  
delay(1000);  
//These guys are insane hackers
//haukur plis
}//end loop

