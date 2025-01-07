# Step 1: Use an official PHP image as a base
FROM php:8.1-cli

# Step 2: Set the working directory inside the container
WORKDIR /usr/src/app

# Step 3: Copy your PHP code (index.php) into the container
COPY . .

# Step 4: Expose the port (if you later want to serve it via a web server)
EXPOSE 8080

# Step 5: Run the PHP script using the PHP CLI (this runs index.php directly)
CMD ["php", "index.php"]
