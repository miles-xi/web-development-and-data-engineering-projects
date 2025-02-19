import requests
import json

LOCATIONS = ['Toronto,CA', 'New York,US', 'London,GB', 'Tokyo,JP']
API_KEY = 'your_api_key'

WEATHER_URL = 'http://api.openweathermap.org/data/2.5/weather'
AQ_URL = "http://api.openweathermap.org/data/2.5/air_pollution"

def fetch_weather(location):
    params = {'q':location, 'appid':API_KEY, 'units':'metric'}
    response = requests.get(WEATHER_URL, params)
    if response.status_code == 200:
        return response.json()
    else:
        raise Exception(f'Failed to get weather data: status code{response.status_code}')
    
def fetch_aq(lat, lon):
    params = {'lat':lat, 'lon':lon, 'appid':API_KEY}
    response = requests.get(AQ_URL, params)
    if response.status_code == 200:
        return response.json()
    else:
        raise Exception(f'Failed to get air quality data: status code{response.status_code}')

def extract_data():
    extracted_data = []
    
    for loc in LOCATIONS:
        # Get weather data
        weather_data = fetch_weather(location=loc)
        
        # Get air quality data
        if 'coord' in weather_data:
            lat, lon = weather_data['coord']['lat'], weather_data['coord']['lat']
            aq_data = fetch_aq(lat, lon)
        else:
            aq_data = None
        
        extracted_data.append((weather_data, aq_data))
    
    with open('extracted_data.json', 'w') as file:
        json.dump(extracted_data, file, indent=4)


if __name__ == '__main__':
    extract_data()



