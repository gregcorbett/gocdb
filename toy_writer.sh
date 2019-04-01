#!/bin/bash

i=$1

while [ $i -lt 1000 ] && [ ! -f './stop' ]
do
    php toy_writer.php $i
    echo -n "$i, "
    i=$[$i + 2]

done
