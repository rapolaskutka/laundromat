# Laundromat Reservation System

## Introduction
The Laundromat Reservation System is a web application built using the Symfony framework. It's designed to streamline the process of reserving laundry machines in a laundromat. The system allows users to view available machines, book time slots, and manage their reservations.

## Features
- **User Authentication**: Secure login and registration system.
- **Machine Availability**: Real-time status of laundry machines.
- **Reservation Management**: Users can make, view past and future reservations.

## Prerequisites
- Docker and Docker Compose

## Installation

### Step 1: Clone the Repository
git clone github.com/rapolaskutka/laundromat
cd ./laundromat
### Step 2: Navigate to Docker Directory
cd ./docker
### Step 3: Start Docker Containers
Run the following command to start the Docker containers. This will set up the environment required for the application, including the web server, database, and any other services defined in the `docker-compose.yml` file.

docker-compose up
