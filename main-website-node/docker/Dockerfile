FROM node:18

# Set working directory
WORKDIR /app

# Copy package files and install dependencies
COPY package*.json ./


# Copy the rest of your app
COPY . .

# Install dependencies

#RUN npm install

# Expose the port (optional, e.g., 3000)
EXPOSE 3000

# Start the app
CMD ["npm", "install"]
#CMD ["npm", "start"]
