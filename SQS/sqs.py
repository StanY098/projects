#---------------------------------------------import packages---------------------------------------------
import boto3
import json
import requests
#---------------------------------------------define functions---------------------------------------------
def changeBodyContent(body):
    body = core(body)
    #add temperature in F
    body['Temperature_F'] = extra_weather(body)
    #add time zone
    body['TimezoneABBR'] = extra_time(body)
    return body
def core(body):
    #add worker ID
    body['_worker'] = 'stanleyhung0908'
    #change phone number format
    phone = body['Phone'].split("-")
    body['Phone'] = ''.join(phone)
    return body
def extra_weather(body):
    zipcode = body['Zip']
    api = '5e0d7b7f84d751f5f6421bc57d62630f'
    request = requests.get('http://api.openweathermap.org/data/2.5/weather?zip=' + str(zipcode) + ',us&APPID=' + api)
    return request.json()['main']['temp'] * 9.0 / 5.0 - 459.67
def extra_time(body):
    zipcode = body['Zip']
    api = 'QUNvqmqZ8jpMfJ1EzuqNmZKnOdX5gomEdJaGEcOVHVGQSkkr2SsMAsh4izgIXIEx'
    r = requests.get('https://www.zipcodeapi.com/rest/' + api + '/info.json/' + zipcode + '/degrees')
    return r.json()['timezone']['timezone_abbr']
#---------------------------------------------define steps---------------------------------------------
#resource
resource = boto3.resource('sqs', region_name = 'us-east-1', aws_access_key_id = 'AKIAJI2SR5ZMXVCJLDGQ', aws_secret_access_key = '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')
#url
queue_url = resource.get_queue_by_name(QueueName = 'cs415_jobs').url
#client
client = boto3.client('sqs', region_name = 'us-east-1', aws_access_key_id = 'AKIAJI2SR5ZMXVCJLDGQ', aws_secret_access_key = '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')
#start processing messages
count = 0
while count < 10:
    #receive message
    message = client.receive_message(QueueUrl = queue_url, AttributeNames = ['SentTimestamp'], MaxNumberOfMessages = 1, MessageAttributeNames = ['All'], VisibilityTimeout = 0, WaitTimeSeconds = 0)
    #body
    body = json.loads(message['Messages'][0]['Body'])
    #editting the message content (adding worker ID and changing phone format)
    body = changeBodyContent(body)
    #result queue
    result = resource.get_queue_by_name(QueueName = 'cs415_results')
    #send message
    client.send_message(QueueUrl = result.url, MessageBody = json.dumps(body))
    #delete message
    client.delete_message(QueueUrl = queue_url,ReceiptHandle = message['Messages'][0]['ReceiptHandle'])
    #increment
    count += 1
