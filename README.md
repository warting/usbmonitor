usbmonitor
==========

run a script that fetches all usb serial and send it to pi.php something like this:

/bin/cat /proc/bus/usb/devices > /tmp/usb.txt
/usr/bin/curl -i -F name=usb -F filedata=@/tmp/usb.txt http://domain.com/pi.php
