FROM node:22-alpine AS build
WORKDIR /usr/src/app
ARG VITE_API_URL=/api
ARG VITE_REVERB_APP_KEY
ARG VITE_REVERB_HOST=localhost
ARG VITE_REVERB_PORT=8080
ARG VITE_REVERB_SCHEME=ws
ENV VITE_API_URL=$VITE_API_URL \
	VITE_REVERB_APP_KEY=$VITE_REVERB_APP_KEY \
	VITE_REVERB_HOST=$VITE_REVERB_HOST \
	VITE_REVERB_PORT=$VITE_REVERB_PORT \
	VITE_REVERB_SCHEME=$VITE_REVERB_SCHEME
COPY react-proyecto/package.json .
RUN npm install
RUN npm install react-calendar swiper html5-qrcode
COPY react-proyecto .
RUN rm -rf node_modules && npm install
RUN npm run build

FROM nginx:alpine
COPY --from=build /usr/src/app/dist /usr/share/nginx/html
COPY nginx.conf /etc/nginx/conf.d/default.conf
EXPOSE 80
