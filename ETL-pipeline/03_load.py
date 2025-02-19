import mysql.connector
import json

# Database configuration
DB_CONFIG = {
    "host": 'weather-pipeline-db.thispartisremoved.us-east-2.rds.amazonaws.com',
    "user": "admin",
    "password": 'yourpassword',
    "database": "weather_pipeline"
}

def load_data():
    # Connect to mysql
    db = mysql.connector.connect(**DB_CONFIG)
    cursor = db.cursor()

    # Read transformed data
    with open('transformed_data.json', 'r') as file:
        transformed_data = json.load(file)
    for data in transformed_data:
        city, country = data["city"], data["country"]
        temperature, humidity, observation_time = data["temperature"], data["humidity"], data["observation_time"]
        aqi = data.get("aqi")

        # Check if location exists
        stmt = "SELECT location_id FROM locations WHERE city=%s AND country=%s"
        cursor.execute(stmt, (city, country))
        location = cursor.fetchone()
        if location:
            location_id = location[0]
        else:
            # Insert new location to 'locations' tables
            stmt = '''INSERT INTO locations (city, country) VALUES (%s, %s)'''
            cursor.execute(stmt, (city, country))
            db.commit()
            location_id = cursor.lastrowid
        
        # Insert weather data to 'weather_data' table
        stmt = '''
            INSERT INTO weather_data (location_id, temperature, humidity, observation_time)
            VALUES (%s, %s, %s, %s)'''
        cursor.execute(stmt, (location_id, temperature, humidity, observation_time))
        db.commit()

        # Insert aq data if available
        if aqi is not None:
            stmt = '''
                INSERT INTO air_quality_data (location_id, aqi, observation_time)
                VALUES (%s, %s, %s)'''
            cursor.execute(stmt, (location_id, aqi, observation_time))
            db.commit()
    
    cursor.close()
    db.close()

if __name__ == '__main__':
    load_data()

