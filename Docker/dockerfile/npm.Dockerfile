# Gunakan image node.js sebagai dasar
FROM node:latest

# Set working directory
WORKDIR /var/www

# Copy file package.json dan package-lock.json
COPY package.json ./

# Hapus node_modules dan package-lock.json jika ada (antisipasi cache sebelumnya)
RUN rm -rf node_modules package-lock.json

# Install dependencies
RUN npm i --legacy-peer-deps

# Copy seluruh source code aplikasi ke dalam container
COPY . .

# Menjalankan frontend build
CMD ["npm", "run", "dev"]
