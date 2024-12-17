# Gunakan image node.js sebagai dasar
FROM node:20-bullseye

# Set working directory
WORKDIR /var/www

# Update npm version
RUN npm install -g npm@latest

# Copy file package.json dan package-lock.json
COPY package.json ./

# Hapus node_modules dan package-lock.json jika ada (antisipasi cache sebelumnya)
RUN rm -rf node_modules package-lock.json

# Install dependencies
RUN npm i --legacy-peer-deps

# Copy seluruh source code aplikasi ke dalam container
COPY . .

# Hapus public/hot
RUN rm -rf /var/www/public/hot

# Menjalankan frontend build
CMD ["npm", "run", "dev"]
