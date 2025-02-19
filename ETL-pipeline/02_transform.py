import json
from datetime import datetime

# Read extracted data
def load_extracted_data():
    with open('extracted_data.json', 'r') as file:
        return json.load(file)

def transform_data():
    data = load_extracted_data()
    transformed_data = []

    for weather_data, aq_data in data:
        if 'main' not in weather_data or 'coord' not in weather_data:
            continue
        
        city = weather_data.get('name', 'Unknown')
        country = weather_data.get('sys', {}).get('country', 'Unknown')
        temp = round(weather_data['main']['temp'], 2)
        humidity = weather_data['main'].get('humidity', None)
        timestamp = weather_data.get('dt', None)
        obs_time = datetime.fromtimestamp(timestamp).strftime('%Y-%m-%d %H:%M:%S') if timestamp else None

        lat,lon = weather_data['coord']['lon'], weather_data['coord']['lat']
        aq_index = aq_data.get('list', [{}])[0].get('main', {}).get('aqi', None)

        transformed_data.append({
            "city": city,
            "country": country,
            "temperature": temp,
            "humidity": humidity,
            "observation_time": obs_time,
            "latitude": lat,
            "longitude": lon,
            "aqi": aq_index
        })
    
    with open('transformed_data.json', 'w') as file:
        json.dump(transformed_data, file, indent=4)

if __name__ == "__main__":
    transform_data()


