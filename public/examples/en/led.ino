/*

 * Função: Comunicação serial (leitura e escrita), LED vermelho e visor LCD 16x2
 * LED: pino 2. LCD RGB. Porta serial: baudrate 9600
 */

#include <Wire.h>                                       
#include "rgb_lcd.h" // Biblioteca do visor LCD
String state;                                       
rgb_lcd lcd;

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

  lcd.setCursor(1, 0);   // Cursor na posição inicial (coluna, linha)
  lcd.print("LED Desligado");   // Escreve texto no LCD
  lcd.setCursor(5, 1);   // Cursor na posiÃ§Ã£o inicial (coluna, linha)
  lcd.print("ON liga");    // Escrevendo texto no LCD
  Serial.println("LED desligado!");  // Imprime o valor definido na porta serial
  pinMode (2, OUTPUT);     // Define o pino 2 para o LED


}

void loop() {
  while (Serial.available() == 0) {               // Verifica se a porta serial está disponível

  }
  state = Serial.readString();                    //Lê os valores digitados

  if (state == "ON") {                            // Verifica se o que foi digitado pelo usuário no Serial Monitor é igual a "ON"
    lcd.clear();                                  // Limpa o LCD
    lcd.setCursor(3, 0);                          // Cursor na posição inicial (coluna, linha)
    lcd.print("LED Ligado");                      // Escrevendo texto no LCD
    lcd.setCursor(3, 1);                          // Cursor na posição inicial (coluna, linha)
    lcd.print("OFF desliga");                     // Escrevendo texto no LCD
    Serial.println("LED ligado!");                // Envia dados via porta serial
    digitalWrite(2, HIGH);                       // Liga o LED no pino 2  

  } else if (state == "OFF") {                    // Caso valor digitado não seja "ON" verfica se o valor é "OFF" e executa a ação
    lcd.clear();                                  // Limpa o visor LCD
    lcd.setCursor(1, 0);                          // Cursor na posição inicial (coluna, linha)
    lcd.print("LED Desligado");                   // Escrevendo texto no LCD
    lcd.setCursor(5, 1);                          // Cursor na posição inicial (coluna, linha)
    lcd.print("ON liga");                         // Escrevendo texto no LCD 
    digitalWrite(2, LOW);                        // Desliga o LED no pino 26
    Serial.println("LED desligado!");             // Envia dados via porta serial

  }
}