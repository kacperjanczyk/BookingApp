FROM node:20-alpine

WORKDIR /app

# Instalacja globalnych narzędzi
RUN npm install -g create-react-app

# Kopiowanie package.json i instalacja zależności
# (będzie to wykonane później, gdy utworzysz projekt React)
COPY package*.json ./
RUN npm install || true

EXPOSE 3000

CMD ["npm", "start"]
