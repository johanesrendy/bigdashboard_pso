# Gunakan image node.js sebagai dasar
FROM node:latest

# Set working directory
WORKDIR /var/www

# Copy file package.json dan package-lock.json
COPY package.json package-lock.json ./

# Install dependencies
RUN npm install

# Copy seluruh source code aplikasi ke dalam container
COPY . .

# Menjalankan frontend build
CMD ["npm", "run", "dev"]
