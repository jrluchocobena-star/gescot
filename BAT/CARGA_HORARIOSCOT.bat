@echo off
SET PATH="D:\XAMPP\PHP"
START PHP d:\xampp\htdocs\cot\carga_horarios_cot.php
timeout /t 240 /nobreak
exit