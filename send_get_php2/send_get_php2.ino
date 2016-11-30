#include "dht.h"
dht DHT;
#define DHT22_PIN 9

int CO_analogPin = A0;
int limit;
int co_value;
int mq3_analogPin = A0;
#include <Ethernet.h>
#include <SPI.h>

byte mac[] = { 0x90, 0xA2, 0xDA, 0x0F, 0x2A, 0x8D };
byte ip[] = { 10, 220, 216, 83 };
byte gw[] = {10,220,216,1};
byte subnet[] = { 255, 255, 255, 0 };

EthernetClient client;//(server, 80);

byte server[] = { 10, 200, 10, 24 }; 

int data = 100;
int data2 = 100;
int data3 = 100;

void setup()
{

Serial.begin(9600);               

Ethernet.begin(mac, ip, gw, gw, subnet);

pinMode(4, OUTPUT);
pinMode(7, OUTPUT);

tone(8,1047,350);
delay(200);
tone(8,1319,350); 
delay(200);
tone(8,1568,350);
delay(200);

}

void loop()
{ 
  //READ DATA
  co_value = analogRead(CO_analogPin);
  int gildi = DHT.read22(DHT22_PIN);
  float temp_value = DHT.temperature;
  float humid_value = DHT.humidity;
  
  Serial.println("Program running...");

  delay(5000);
  senddata();                                 


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
  if(co_value > 90)
    tone(8, 494, 500);
    
  int sec = 1000;
  delay(sec);




}
void senddata()
{

Serial.println();
Serial.println("ATE :)");
delay(1000);                                    

if (client.connect(server, 80)) {
Serial.println("Connected");
client.print("GET /2t/2411972479/RobLoka/add2.php?data=");
client.print(co_value);
client.print("&data2=");
client.print(DHT.temperature);
client.print("&data3=");
client.print(DHT.humidity);
client.println(" HTTP/1.1");
client.println("Host: 10.200.10.24");
client.println("Connection: close");
client.println();
Serial.println();
while(client.connected()) {
  while(client.available()) {
    Serial.write(client.read());
    }
   }
   delay(900000);
}

else
{
Serial.println("Connection unsuccesful");
}
//}
 //stop client
 client.stop();
 while(client.status() != 0)
{
  delay(5);
}
}
