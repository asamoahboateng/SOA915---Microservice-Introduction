FROM python:3.12-slim

WORKDIR /app

# Copy the server file from parent directory
COPY ../server.py .

# static/ will be mounted via volume
EXPOSE 8000

CMD ["python", "server.py"]
