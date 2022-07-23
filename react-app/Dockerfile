FROM node:16.16-alpine

WORKDIR /usr/src/app/react-app

COPY package*.json ./

RUN npm install

EXPOSE 3029

CMD ["npm", "start"]