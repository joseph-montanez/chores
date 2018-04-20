<?php

return [
    'java' => env('FOP_JAVA', false), //'C:\\Program Files\\Java\\jdk1.8.0_112\\bin\\java.exe',
    'classpath' => env('FOP_CLASSPATH', false), //C:\\Users\\josephmontanez\\Applications\\fop-2.1\\lib,
    'jar_dir' => env('FOP_JAR_DIR', false), //C:\\Users\josephmontanez\\Applications\\fop-2.1\\build\\
    'jar' => env('FOP_JAR', 'fop.jar'), // fop.jar
];