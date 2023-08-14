import argparse
import time
import numpy as np
import random
import requests

def sendDataToServer(eegdata,acceldata,timestampdata,fsampling):
	url='http://192.168.175.212/api.php'
	apikey='ff5f9ee86c6e510749a024415eb05a14'
	#print(timestampdata[0])
	starttimestamp=timestampdata[0]
	endtimestamp=timestampdata[-1]
	datapoints=len(timestampdata)
	waveformdata=np.transpose(np.vstack((timestampdata,eegdata,acceldata)))
	jsondata = {'apikey':apikey, 'waveformdata': waveformdata.tolist(),'starttimestamp': starttimestamp, 'endtimestamp':endtimestamp,'datapoints':datapoints,'samplingfreq':fsampling}
	response = requests.post(url, json=jsondata,timeout=5)
	print(response.text)



eeg_data=[1990,2323,52553,8410,920]
timestamp_data=[0,1,2,3,4]
accel_data=[10,11,12,13,14]
fs=1200
sendDataToServer(eeg_data,accel_data,timestamp_data,fs)
