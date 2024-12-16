# Gunakan image node.js sebagai dasar
FROM node:18-bullseye

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

# Hapus folder public/hot jika ada
RUN if [ -d "/var/www/public/hot" ]; then \
      echo "Hapus folder /var/www/public/hot"; \
      rm -rf /var/www/public/hot; \
    fi

# Verifikasi penghapusan
RUN if [ ! -d "/var/www/public/hot" ]; then \
      echo "Folder hot berhasil dihapus"; \
    else \
      echo "Gagal menghapus folder hot"; \
      exit 1; \
    fi

# Menjalankan frontend build
CMD ["npm", "run", "dev"]
