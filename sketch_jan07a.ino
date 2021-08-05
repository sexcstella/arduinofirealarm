
#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <ArduinoJson.h>



const char* ssid = "GlobeAtHome_A86C4_2.4";
const char* password = "ASWQAZ123...";
float temp;
const char* host = "firealarm69.000webhostapp.com";
int buzzer = D7; // use for buzzer alert
int FlamePin = D0; // This is for input pin
int Flame = 1; // Flame sensor is set on Passive state
int sirenStat = 1;



// Create an instance of the server


// specify the port to listen on as an argument





void setup() {
pinMode(buzzer, OUTPUT);
pinMode(FlamePin, INPUT);
pinMode(13, OUTPUT);

 Serial.begin(115200);

 // prepare GPIO2



 // Connect to WiFi network
 Serial.println();
 Serial.println();
 Serial.print("Connecting to ");
 Serial.println(ssid);

 WiFi.begin(ssid, password);

 while (WiFi.status() != WL_CONNECTED) {
 delay(500);
 Serial.print(".");
 }
 Serial.println("");
 Serial.println("WiFi connected");

 // Start the server

 Serial.println("Server started");
 // Print the IP address
 Serial.println(WiFi.localIP());

 
}
void loop()
{

 
 // Get sirenState from webpage and assign to integer variable "value"
HTTPClient http;    //Declare object of class HTTPClient
  http.begin("http://firealarm69.000webhostapp.com/getValue.php");
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");

  int httpCode = http.GET();   //Get the request
  String payload = http.getString();    //Get the response payload

  Serial.println(httpCode);   //Print HTTP return code
  Serial.println(payload);
http.end();  //Close connection

int value = payload.toInt();

changeSirenState(value);
Serial.println(value);




 //Read Temperature sensor input 
  temp = analogRead(A0);
   // read analog volt from sensor and save to variable temp
   temp = temp * (3.03 /1024) * 100;
   // convert the analog volt to its temperature equivalent
   Serial.print("TEMPERATURE = ");
   Serial.print(temp); // display temperature value
   Serial.print("*C");
   Serial.println();
   delay(1000); // update sensor reading each one second
  
//Read Flame sensor input
Flame = digitalRead(FlamePin);
Serial.print(Flame);
Serial.print("poop");
//Check temp and flame

sirenStat = (Flame == 0 || temp >= 40 || value == 1)? 1:0;
changeSirenState(sirenStat);




 http.begin(String("http://firealarm69.000webhostapp.com/connect.php?temperature=" )+ temp );
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");

   httpCode = http.GET();   //Get the request
  payload = http.getString();    //Get the response payload

  Serial.println(httpCode);   //Print HTTP return code
  Serial.println(payload);
http.end();  //Close connection


   Serial.println();
   Serial.println("closing connection");


  
}


void changeSirenState(int stat){


HTTPClient http;    //Declare object of class HTTPClient


if (stat == 0)
  {
    Serial.println("No flame");
    noTone(buzzer);
   //the flame sensor is on Passive state
    
  }
  else
  {
    Serial.println("High flame");
   tone(buzzer,1600);  //the flame sensor is on active state

http.begin("http://firealarm69.000webhostapp.com/siren.php");
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");

  int httpCode = http.GET();   //Get the request
  String payload = http.getString();    //Get the response payload

  Serial.println(httpCode);   //Print HTTP return code
  Serial.println(payload);
http.end();  //Close connection



        
    }
   

  




      //Update sirenState in Database
 
 http.begin(String("http://firealarm69.000webhostapp.com/update.php?state=" )+ stat );
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");

  int httpCode = http.GET();   //Get the request
  String payload = http.getString();    //Get the response payload

  Serial.println(httpCode);   //Print HTTP return code
  Serial.println(payload);
http.end();  //Close connection


}
