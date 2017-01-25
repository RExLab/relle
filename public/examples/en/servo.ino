/*

   Função: Comunicação serial (leitura e escrita), LED vermelho e visor LCD 16x2
   LED: pino 2. LCD RGB. Porta serial: baudrate 9600
*/

#include <Servo.h>  // Adiciona a biblioteca do Servo
#include <Wire.h>
#include "rgb_lcd.h" // Biblioteca do visor LCD
String state;
rgb_lcd lcd;

Servo myservo;                 // Instância do objeto do servo
int pos = 0;                   // Posição do servo

/* LCD Colours */
const int colorR = 0;
const int colorG = 0;
const int colorB = 255;

void setup() {        // Função setup de execução unica
  Serial.begin(9600);    // Inicializa porta serial com baud de 9600
  Serial.println("RExLab - UFSC || GT-mre");  // Envia valores via porta serial

  lcd.begin(16, 2);  // Número total de Colunas e Linhas
  lcd.setRGB(colorR, colorG, colorB); //Aplica as cores ao visor

  lcd.print("RexLab UFSC");  // Imprime no visor
  delay(5000);    // Tempo de espera
  lcd.clear();   // Limpando o display LCD

  lcd.setCursor(2, 0);   // Cursor na posição inicial (coluna, linha)
  lcd.print("Display LCD"); // Escrevendo texto no LCD
  lcd.setCursor(5, 1);  // Cursor na posição inicial (coluna, linha)
  lcd.print(" + Servo");     // Escrevendo texto no LCD
  delay(4000);        // Tempo de espera
  lcd.clear();    // Limpando LCD
  myservo.attach(5);


}

void loop() {
  for (pos = 0; pos <= 180; pos++)    // Laço de repetição para girar de 0 a 180º
  {

    lcd.setCursor(0, 0);       // Cursor na posição inicial (coluna, linha)
    lcd.print("Girando para");    // Escreve no visor LCD
    lcd.setCursor(4, 1);    // Cursor na posição inicial (coluna, linha)
    lcd.print("ESQUERDA");  // Escreve no visor LCD
    myservo.write(pos);   // Posiciona o servo na posição 'pos'
    delay(15);  // Espera 15ms
  }
  lcd.clear();  // Limpa o visor LCD

  for (pos = 180; pos >= 0; pos--)       // Laço de repetição para girar de 180 a 0
  {
    lcd.setCursor(0, 0);    // Cursor na posição inicial (coluna, linha)
    lcd.print("Girando para");   // Escreve no visor LCD
    lcd.setCursor(4, 1);    // Cursor na posição inicial (coluna, linha)
    lcd.print("DIREITA");    // Escreve no visor LCD
    myservo.write(pos);    // Move o servo para a posição "pos"
    delay(15);   // Espera 15ms
  }
  lcd.clear();   // Limpa o visor LCD
}
