<?php
$name="John Doe";
print "<h1>".basename(__FILE__)."</h1>";
print "<h2>This is a test!</h2>";
var_dump($name);
print "<h3>All about ".$name."…</h3>";

for ($i = 0; $i < 10;$i++){
    print $i." to power ".($i+1)." => ".pow($i,$i+1)."<br/>";
}

print "<br/>";

//Rekurencja
function fibo($n)
{
  if ($n == 0) return 0;
  if ($n == 1) return 1;
  return fibo($n-1)+fibo($n-2);
}
echo "fibo(19)=".fibo(19)."<br/>";
echo "fibo(8)=".fibo(8)."<br/>";

//Iteracja//Iteracja
$fib1 = 0; $fib2 = 1; $n = 8;
echo $fib1.", ";
for ($i=0; $i<$n; $i++)
{
  echo $fib2.", ";
  $fib2 = $fib2+$fib1;
  $fib1 = $fib2-$fib1;
}

?>