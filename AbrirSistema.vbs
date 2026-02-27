Set WshShell = CreateObject("WScript.Shell")

' 1. Ejecuta el motor del servidor de forma oculta (el 0 al final oculta la ventana)
WshShell.Run "cmd /c run_server.bat", 0, false

' 2. Espera 5 segundos para que el sistema arranque (seguro para HDD lentos)
WScript.Sleep 5000

' 3. Abre el navegador directamente en el punto de venta
WshShell.Run "cmd /c start http://localhost:8000", 0, false