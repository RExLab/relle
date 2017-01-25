// Projeto : Controle de luminosidade de led com LDR  
// Autor : Arduino e Cia  
   
int valorpot = 0; //Armazena valor lido do LDR, entre 0 e 1023  
float luminosidade = 0; //Valor de luminosidade do led  
   
void setup()  
{  
  Serial.begin(9600);    //Inicializa a serial  
  pinMode(2, OUTPUT); //Define o pino do led como saída  
  pinMode(0, INPUT);  //Define o pino do LDR como entrada  
}  
   
void loop()  
{  
  // Le o valor - analogico - do LDR  
  valorpot = analogRead(0);  

  // Converte o valor lido do LDR
  luminosidade = map(valorpot, 0, 1023, 0, 255); 
  Serial.print("Valor lido do LDR : ");   

  // Mostra o valor lido do LDR no monitor serial  
  Serial.print(valorpot);  
  Serial.print(" = Luminosidade : ");  

  // Mostra o valor da luminosidade no monitor serial  
  Serial.println(luminosidade); 
  
  analogWrite(2, luminosidade); 
  delay(4000);
 }  