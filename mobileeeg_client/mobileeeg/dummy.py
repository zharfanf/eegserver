import argparse
import time
import numpy as np
import random

def sendDataToServer(eegdata,acceldata,timestampdata,fsampling):
	url='https://mobileeeg.yzd.my.id/api.php'
	apikey='68d79521339f81b3c90c2a8d631bda5f'
	#print(timestampdata[0])
	starttimestamp=timestampdata[0]
	endtimestamp=timestampdata[-1]
	datapoints=len(timestampdata)
	waveformdata=np.transpose(np.vstack((timestampdata,eegdata,acceldata)))
	jsondata = {'apikey':apikey, 'waveformdata': waveformdata.tolist(),'starttimestamp': starttimestamp, 'endtimestamp':endtimestamp,'datapoints':datapoints,'samplingfreq':fsampling}
	response = requests.post(url, json=jsondata,timeout=0.001)
	print(response.text)

eeg_data=[5,6,7,8,9]
timestamp_data=[0,1,2,3,4]
accel_data=[10,11,12,13,14]
fs=1200
sendDataToServer(eeg_data,accel_data,timestamp_data,fs)