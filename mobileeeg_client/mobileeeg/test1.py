import argparse
import time
import numpy as np

import brainflow
from brainflow.board_shim import BoardShim, BrainFlowInputParams
from brainflow.data_filter import DataFilter, FilterTypes, AggOperations
import requests



def sendDataToServer(eegdata,acceldata,timestampdata,fsampling):
	url='https://mobileeeg.yzd.my.id/api.php'
	apikey='806ec09856a98464d5a00aed56ac04ec'
	#print(timestampdata[0])
	starttimestamp=timestampdata[0]
	endtimestamp=timestampdata[-1]
	datapoints=len(timestampdata)
	waveformdata=np.transpose(np.vstack((timestampdata,eegdata,acceldata)))
	jsondata = {'apikey':apikey, 'waveformdata': waveformdata.tolist(),'starttimestamp': starttimestamp, 'endtimestamp':endtimestamp,'datapoints':datapoints,'samplingfreq':fsampling}
	response = requests.post(url, json=jsondata,timeout=0.001)
	print(response.text)

def getDataSegment(segmentleninseconds=5):
	board_id=0 #cyton=0
	serial_port='/dev/cu.usbserial-DM03H5DJ'  #in raspberry pi 3+ =/dev/ttyUSB0


	#BoardShim.enable_dev_board_logger()
	BoardShim.disable_board_logger()

	params = BrainFlowInputParams()
	params.serial_port = serial_port
	board = BoardShim(board_id, params)

	board.prepare_session()


	fsampling=board.get_sampling_rate(board_id)
	eegch=board.get_eeg_channels(board_id)
	timestampch=board.get_timestamp_channel(board_id)
	accelch=board.get_accel_channels(board_id)

	segmentlen=segmentleninseconds*fsampling
	board.start_stream(45000)
	time.sleep(2)
	# data = board.get_current_board_data (256) # get latest 256 packages or less, doesnt remove them from internal buffer
	while True:

		if board.get_board_data_count()>segmentlen:

			data = board.get_board_data(segmentlen)  # get all data and remove it from internal buffer
			eegdata=data[eegch]
			timestampdata=data[timestampch]
			acceldata=data[accelch]

			sendDataToServer(eegdata,acceldata,timestampdata,fsampling)
			#print(eegdata)
			#print(timestampdata)
			#print(acceldata)
			time.sleep(0.5)
			
	board.stop_stream()
	board.release_session()



if __name__ == "__main__":
	getDataSegment()
