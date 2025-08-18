#!/bin/bash

echo "WordPress Docker Setup with TailPress Theme"
echo "=========================================="
echo ""

# Check if Docker is running
if ! docker info > /dev/null 2>&1; then
    echo "Docker is not running. Please start Docker first."
    exit 1
fi

# Check if Docker Compose is available
if ! command -v docker-compose &> /dev/null; then
    echo "Docker Compose is not installed. Please install Docker Compose first."
    exit 1
fi

echo "Docker environment check passed"
echo ""

# Create necessary directories
echo "Creating directories..."
mkdir -p themes plugins uploads
echo "Directories created"
echo ""

# Start Docker containers
echo "Starting Docker containers..."
docker-compose up -d

if [ $? -eq 0 ]; then
    echo "Docker containers started successfully"
    echo ""

    echo "Waiting for services to be ready..."
    sleep 10

    echo ""
    echo "Checking service status..."
    docker-compose ps
    echo ""

    echo "WordPress Setup Information:"
    echo "============================"
    echo "Website URL: http://localhost:8000"
    echo "Admin Panel: http://localhost:8000/wp-admin"
    echo "Username: admin"
    echo "Password: admin123"
    echo ""

    echo "Monitoring setup progress..."
    echo "Press Ctrl+C to stop monitoring (services will continue running)"
    echo ""

    # Monitor WP CLI setup
    docker-compose logs -f wp-cli

else
    echo "Failed to start Docker containers"
    echo "Check the error messages above and try again"
    exit 1
fi
