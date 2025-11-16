<!--
data = new Date();
semana = data.getDay();
Dia = data.getDate();
mes = data.getMonth()+1;
ano = data.getYear()+1900;

if(semana == 0)
semana2 = " Domingo" 

else if(semana == 1)
semana2 = " Segunda-Feira" 

else if(semana == 2)
semana2 = " Terça-Feira" 

else if(semana == 3)
semana2 = " Quarta-Feira" 

else if(semana == 4)
semana2 = " Quinta-Feira" 

else if(semana == 5)
semana2 = " Sexta-Feira" 

else if(semana == 6)
semana2 = " Sábado" 

if (mes == 1)
mes="Janeiro"

else if(mes == 2)
  mes="Fevereiro"
  
else if(mes == 3)
  mes="Março"
  
else if(mes == 4)
  mes="Abril"
  
else if(mes == 5)
  mes="Maio"
  
else if(mes == 6)
  mes="Junho"
  
else if(mes == 7)
  mes="Julho"
  
else if(mes == 8)
  mes="Agosto"
  
else if(mes == 9)
  mes="Setembro"
  
else if(mes == 10)
  mes="Outubro"
  
else if(mes == 11)
  mes="Novembro"
  
else if(mes == 12)
mes="Dezembro"

if(Dia == 1)
Dia = "01"; 
if(Dia == 2)
Dia = "02"; 
if(Dia == 3)
Dia = "03"; 
if(Dia == 4)
Dia = "04"; 
if(Dia == 5)
Dia = "05"; 
if(Dia == 6)
Dia = "06"; 
if(Dia == 7)
Dia = "07"; 
if(Dia == 8)
Dia = "08"; 
if(Dia == 9)
Dia = "09"; 

document.write(semana2+", "+Dia+" de "+mes+" de "+ano)