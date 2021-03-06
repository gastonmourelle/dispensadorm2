/*---------------Comunicación serial-----------------*/
#include <SoftwareSerial.h>
SoftwareSerial arduino_serial(2, 3);
int dato_recibido = 0;
float g;

/*---------------Motor paso a paso-----------------*/
#include <Stepper.h>
#define motor_velocidad 10 //Velocidad a la cual se moverá el motor a pasos 0-3 rpm
#define gramos_vuelta 100 // Cambiar valor para ajustar giros
#define pasos_vuelta 2048
Stepper motor(pasos_vuelta, 8, 6, 9, 7);

/*---------------Celda de carga-----------------*/
#include <HX711_ADC.h> // Librerias
#include <Wire.h>
HX711_ADC celda(10, 11); // DT | SCK
float peso; // variable peso para pasarle el dato que saco de la celda

/*---------------Ultrasonido-----------------*/
const int ultra_trigger = 4;   //Pin digital 4 para el Trigger del sensor
const int ultra_echo = 5;   //Pin digital 5 para el Echo del sensor
long ultra_tiempo; //timepo que demora en llegar el eco
long ultra_distancia; //distancia en centimetros

/*---------------Bocina-----------------*/
int bocina = 12;


void setup() {
  //--- Serial
  Serial.begin(115200);
  arduino_serial.begin(115200);
  
  //--- Motor
  motor.setSpeed(motor_velocidad);

  //--- Celda de carga
  celda.begin(); // Se conecta a HX711
  celda.start(2000); // Espera 2s para estabilizarse
  celda.setCalFactor(485.0); // Calibracion (no tocar)
  
  //--- Ultrasonido
  pinMode(ultra_trigger, OUTPUT); //pin como salida
  pinMode(ultra_echo, INPUT);  //pin como entrada
  digitalWrite(ultra_trigger, LOW);//Inicializamos el pin con 0

}

void loop() 
{
  //--- Celda de carga
  celda.update();
  peso = celda.getData();
  
  if(arduino_serial.available() > 0)
  {
    dato_recibido = arduino_serial.readStringUntil('\n').toInt();
    Serial.println(dato_recibido);
    
    /*-----------------------------------------------------------------------
    dato_recibido = 1 === (salida del perro - termino de comer)
    dato_recibido = 2 === (ya uso todos sus turnos, no dispensa)
    dato_recibido = 3 === (cooldown activo - tiempo de espera, no dispensa)
    dato_recibido > 3 === (gramos que tiene que dispensar)
    -----------------------------------------------------------------------*/
    
    if (dato_recibido > 3){
      vuelta(calcularVueltas(dato_recibido));
      g = dato_recibido;
    }
    else if (dato_recibido == 1){
      ultrasonido();
      Serial.print("&");Serial.print(peso);Serial.print("&");Serial.print(ultra_distancia);Serial.print("&");
      arduino_serial.print("&");arduino_serial.print(peso);arduino_serial.print("&");arduino_serial.print(ultra_distancia);arduino_serial.print("&");
      int porcentaje = (100 * (peso)) / g;
      if (porcentaje > 25){
        tone(bocina, 100, 300);
      }
    }
  }
}

void vuelta(float vueltas)
{
  if(vueltas > (peso/gramos_vuelta)){
    for(long i = 0; i < ((pasos_vuelta*vueltas) - ((pasos_vuelta)*(peso/gramos_vuelta))); i++)
      motor.step(1);
  }
  else{
    tone(bocina, 100, 1500);
  }
}

float calcularVueltas(float gramos)
{
  return gramos/gramos_vuelta;
}

void ultrasonido(){
  digitalWrite(ultra_trigger, HIGH);
  delayMicroseconds(10);          //Enviamos un pulso de 10us
  digitalWrite(ultra_trigger, LOW);
  
  ultra_tiempo = pulseIn(ultra_echo, HIGH); //obtenemos el ancho del pulso
  ultra_distancia = ultra_tiempo/59;             //escalamos el tiempo a una distancia en cm
}
