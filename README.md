# dontforgetyourumbrella

Simple weather forecasting and precipitation predication.


## Requirements

dontforgetyourumbrella is a small web application that retreives weather forecat information from Weather Undergroung and makes predictions on whether or not you will need an umbrella for a specific day. It also geolocates the user based on their IP address. Text message notifications are sent out using Twilio.


## Installation

This service is designed to be run on a LAMP development platform. The scripts and configuration files cannot be run through a desktop environment. Once cron job is also needed in order to keep the application running.

User account information, including cell phone numbers and zip codes, are stored in one MySQL database.


## Usage

This application is self-sustaining, meaning that once the scripts and configuration files are loaded on a LAMP server, no additional maintenance or overhead is necessary.

dontforgetyourumbrella will check Weather Underground daily for forecast information and precipitation predictions, notifying users according to their location and preferences.


## Disclaimer

Use this application at your own risk. While this application has been tested thoroughly, on the above requirements, your mileage may vary. I take no responsibility for any harmful actions this application might cause.


## License

This software, and its dependencies, are distributed free of charge and licensed under the GNU General Public License v3. For more information about this license and the terms of use of this software, please review the LICENSE.txt file.
