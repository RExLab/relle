/*

 * Função: Comunicação serial (leitura e escrita), LED vermelho e visor LCD 16x2
 * LED: pino 2. LCD RGB. Porta serial: baudrate 9600
 */

#include <Wire.h>                                       
#include "rgb_lcd.h" // Biblioteca do visor LCD
String state;                                       
rgb_lcd lcd;

/* Cores do visor LCD */
const int colorR = 0;
const int colorG = 0;
const int colorB = 255;

/* Parâmetros do LM35 */
int a;
float temperatura;
int B = 3975;                  //B value of the thermistor
float resistencia;

void setup() {        // Função setup de execução unica
  lcd.begin(16, 2);  // Número total de Colunas e Linhas
  lcd.setRGB(colorR, colorG, colorB); //Aplica as cores ao visor

  lcd.setCursor(2, 0);  // Cursor na posição (coluna, linha)
  lcd.print("RExLab - UFSC"); // Escreve esta string no LCD
  lcd.setCursor(4, 1);   // Cursor na posição (coluna, linha)
  lcd.print("GT - mre");     // Escreve esta string no LCD
  delay(5000);    // Tempo de espera
  lcd.clear();   // Limpa o display LCD

  lcd.setCursor(2, 0);    // Cursor na posição (coluna, linha)
  lcd.print("Display LCD");   // Escreve esta string no LCD
  lcd.setCursor(5, 1);   // Cursor na posição (coluna, linha)
  lcd.print("+ LM35");  // Escreve esta string no LCD
  delay(5000);   // Delay de 5000 ms
  lcd.clear();   // Limpa o display LCD
}

void loop() {
  a=analogRead(1);
  resistencia = (float)(1023-a)*10000/a; // Resistência do sensor
  temperatura = 1/(log(resistencia/10000)/B+1/298.15)-273.15; // Converte a temperatura
  delay(1000);
  lcd.setCursor(2, 0);     // Cursor na posição (coluna, linha)
  lcd.print("Temperatura: ");  // Escreve esta string no LCD
  lcd.setCursor(5, 1);   // Cursor na posição (coluna, linha)
  lcd.print(temperatura);   // Escreve a temperatura no LCD
  lcd.print("C"); // Escreve C de Celsius
  delay(2000); // Delay de 2000ms     
}