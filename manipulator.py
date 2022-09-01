import json
import os

flight = 'flight.json'
departure = 'departures.json'
arrival = 'arrivals.json'
currentStatus = 'live_status.json'
flight_details = 'flights.json'
airlines = 'airlines.json'
airports = 'airport.json'
new_airlines = 'modified_airlines.json'
new_airports = 'modified_airports.json'
airplane = "airplanes.json"
new_airplane = "modified_airplanes.json"
# new_data = []
# with open(flight, 'r') as f:
#     data = json.load(f)
#     for se in data:
#         single_info = {}
#         for keys, values in se.items():            
#             try:
#                 for key, value in values.items():
#                     single_info[keys + "." + key] = value            
#             except AttributeError:
#                 single_info[keys] = values
#         new_data.append(single_info)

# with open(new_file, 'w') as jsonFile:
#     json.dump(new_data, jsonFile ,indent=4)

departure_data = []
with open(flight, 'r') as f:
    data = json.load(f)
    for se in data:
        single_info = {}
        flight_info = se["flight"]["icaoNumber"]
        single_info["flightICAO"] = flight_info
        icaoCode = se["departure"]["icaoCode"]
        iataCode = se["departure"]["iataCode"]
        single_info["depIcaoCode"] = icaoCode
        single_info["depIataCode"] = iataCode
        departure_data.append(single_info)
with open(departure, 'w') as jsonFile:
    json.dump(departure_data, jsonFile ,indent=4)

arrival_data = []
with open(flight, 'r') as f:
    data = json.load(f)
    for se in data:
        single_info = {}
        flight_info = se["flight"]["icaoNumber"]
        single_info["flightICAO"] = flight_info
        icaoCode = se["arrival"]["icaoCode"]
        iataCode = se["arrival"]["iataCode"]
        single_info["arrivalIcaoCode"] = icaoCode
        single_info["arrivalIataCode"] = iataCode
        arrival_data.append(single_info)
with open(arrival, 'w') as jsonFile:
    json.dump(arrival_data, jsonFile ,indent=4)


status = []
with open(flight, 'r') as f:
    data = json.load(f)
    for se in data:
        single_info = {}
        flight_info = se["flight"]["icaoNumber"]
        single_info["flightICAO"] = flight_info
        single_info["altitude"] = se["geography"]["altitude"]
        single_info["direction"] = se["geography"]["direction"]
        single_info["latitude"] = se["geography"]["latitude"]
        single_info["longitude"] = se["geography"]["longitude"]
        single_info["horizontalSpeed"] = se["speed"]["horizontal"]
        single_info["verticalSpeed"] = se["speed"]["vspeed"]
        single_info["isGround"] = se["speed"]["isGround"]
        status.append(single_info)
with open(currentStatus, 'w') as jsonFile:
    json.dump(status, jsonFile ,indent=4)
 
flight_ = []
with open(flight, 'r') as f:
    data = json.load(f)
    for se in data:
        single_info = {}
        aircraftRegNumber = se["aircraft"]["regNumber"]
        single_info["aircraftRegNumber"] = aircraftRegNumber
        airlineIcaoCode = se["airline"]["icaoCode"]
        single_info["airlineIcaoCode"] = airlineIcaoCode
        flightIcaoNumber = se["flight"]["icaoNumber"]
        single_info["flightIcaoNumber"] = flightIcaoNumber
        s = se["status"]
        single_info["status"] = s
        flight_.append(single_info)
with open(flight_details, 'w') as jsonFile:
    json.dump(flight_, jsonFile ,indent=4)

airlines_ = []
with open(airlines, 'r') as f:
    data = json.load(f)
    for se in data:
        single_info = {}
        single_info["ageFleet"] = se["ageFleet"]
        single_info["callsign"] = se["callsign"]
        single_info["codeHub"] = se["codeHub"]
        single_info["codeIataAirline"] = se["codeIataAirline"]
        single_info["codeIcaoAirline"] = se["codeIcaoAirline"]
        single_info["founding"] = se["founding"]
        single_info["nameAirline"] = se["nameAirline"]
        single_info["nameCountry"] = se["nameCountry"]
        single_info["sizeAirline"] = se["sizeAirline"]
        airlines_.append(single_info)
with open(new_airlines, 'w') as jsonFile:
    json.dump(airlines_, jsonFile, indent=4)

airports_ = []
with open(airports, 'r', encoding="utf8") as f:
    data = json.load(f)
    for se in data:
        single_info = {}
        single_info["codeIataAirport"] = se["codeIataAirport"]
        single_info["codeIcaoAirport"] = se["codeIcaoAirport"]
        single_info["latitudeAirport"] = se["latitudeAirport"]
        single_info["longitudeAirport"] = se["longitudeAirport"]
        single_info["nameAirport"] = se["nameAirport"]
        single_info["nameCountry"] = se["nameCountry"]
        single_info["time_zone"] = se["timezone"]
        airports_.append(single_info)
with open(new_airports, 'w') as jsonFile:
    json.dump(airports_, jsonFile, indent=4)

airplanes_ = []
with open(airplane, 'r', encoding="utf8") as f:
    data = json.load(f)
    for se in data:
        single_info = {}
        single_info["airplaneIataType"] = se["airplaneIataType"]
        single_info["engineCount"] = se["enginesCount"]
        single_info["enginesType"] = se["enginesType"]
        single_info["numberRegistration"] = se["numberRegistration"]
        single_info["planeAge"] = se["planeAge"]
        single_info["productionLine"] = se["productionLine"]
        airplanes_.append(single_info)
with open(new_airplane, 'w') as jsonFile:
    json.dump(airplanes_, jsonFile, indent=4)

