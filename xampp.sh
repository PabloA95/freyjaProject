#!/bin/bash
if [ $# -gt 0 ]; then
	if [ $1 = "-s" ]; then
		#echo 'Iniciando sublime text';
		#subl;
		echo 'Abriendo directorio';
		nautilus /opt/lampp/htdocs/www/2018-grupo-1;
		echo 'Iniciando servidor de Symfony'
		php bin/console server:start
		echo 'Iniciando lampp';
		sudo /opt/lampp/lampp start;
		echo 'Finalizado';
	elif [ $1 = "-t" ]; then
		echo 'Deteniendo servidor de Symfony'
		php bin/console server:stop
		echo 'Deteniendo lampp';
		sudo /opt/lampp/lampp stop;
	else
		echo 'Ingrese -s para iniciar los servicios';
		echo 'Ingrese -t para detener los servicios';
	fi	
else
	echo 'Ingrese -s para iniciar los servicios';
	echo 'Ingrese -t para detener los servicios';
fi

