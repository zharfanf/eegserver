#! /bin/bash

source ./env/bin/activate
python3 ./test1.py --board-id 0 --serial-port /dev/ttyUSB0

deactivate
