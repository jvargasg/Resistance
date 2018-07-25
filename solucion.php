<?php

/**
* Código para resolver problema "The Resistance" de sitio web CodinGame, como parte del proceso
* para postular a cargo de desarrollador de software en Ubinn.
*
* https://www.codingame.com/training/expert/the-resistance
*/

class Resistance
{
	public $diccionarioMorse = [
        'A' => '.-', 'B' => '-...', 'C' => '-.-.', 'D' => '-..', 'E' => '.', 'F' => '..-.', 'G' => '--.', 'H' => '....', 'I' => '..',
		'J' => '.---', 'K' => '-.-', 'L' => '.-..', 'M' => '--', 'N' => '-.', 'O' => '---', 'P' => '.--.', 'Q' => '--.-', 'R' => '.-.',
		'S' => '...', 'T' => '-', 'U' => '..-', 'V' => '...-', 'W' => '.--', 'X' => '-..-', 'Y' => '-.--', 'Z' => '--..'
    ];
    public $secuencia; // secuencia morse a analizar
	public $palabrasSubstring = []; //arreglo con la lista de palabras y coincidencias de las posiciones

	/**
	* Cuenta las apariciones de las palabras en cada ubicación
	*/
	public function contarMensajes($posicionInicial = 0)
    {    
		$mensajes = 0;
		
		//Validaciones para revisar si es el final o si se pasó del largo del arreglo
        if ($posicionInicial === strlen($this->secuencia)) {
            return 1;
        }
        if (!isset($this->palabrasSubstring[$posicionInicial])) {
            return 0;
        }
        
        foreach ($this->palabrasSubstring[$posicionInicial] as $i => &$subPalabra) {
            $palabra = $subPalabra['palabra'];
            
			if(isset($subPalabra['numEncontrada']))
				$palabraEncontrada = $subPalabra['numEncontrada'];
			else
				$palabraEncontrada = null;
			
            if ($palabraEncontrada !== null) {
                $mensajes += $palabraEncontrada;
                continue;
            }

            $palabraEncontrada           = $this->contarMensajes($posicionInicial + strlen($palabra));
            $mensajes                   += $palabraEncontrada;
            $subPalabra['numEncontrada'] = $palabraEncontrada;
			
        }
        
		return $mensajes;
    }
	
	/**
	* Si la palabra está en la secuencia, se agrega al arreglo de posiciones
	*/
	public function agregarPalabra($palabra)
    {
        $ultimaUbicacion = 0;
        while (($ultimaUbicacion = strpos($this->secuencia, $palabra, $ultimaUbicacion))!== false) {
            if(!isset($this->palabrasSubstring[$ultimaUbicacion])) 
				$this->palabrasSubstring[$ultimaUbicacion] = [];
            
            $this->palabrasSubstring[$ultimaUbicacion][] = ['palabra' => $palabra];
            $ultimaUbicacion                             = $ultimaUbicacion + 1;
        }
    }
	
	/**
	* Retorna una palabra traducida en lenguaje morse
	*/
	public function traducirPalabra($p) {
        $morse = '';
        for ($i=0, $largo=strlen($p); $i<$largo; ++$i) {
            $morse .= $this->diccionarioMorse[$p[$i]];
        }
        return $morse;
    }
	
	/** 
	* Constructor para lectura	de datos de entrada
	*/
    public function __construct()
    {
        fscanf(STDIN, "%s", $this->secuencia);        
        fscanf(STDIN, "%d", $numPalabras);
        for ($i = 0; $i < $numPalabras; ++$i) {
            fscanf(STDIN, "%s", $palabra);
            $this->agregarPalabra($this->traducirPalabra($palabra)); //se traducen las palabras y se agregan al arreglo
        }
    }
}// fin clase Resistance

$ejercicio = new Resistance();
$respuesta = $ejercicio->contarMensajes();
echo $respuesta."\n";