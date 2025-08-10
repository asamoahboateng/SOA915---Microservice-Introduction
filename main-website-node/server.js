const express = require('express');
const amqp = require('amqplib');
const cors = require('cors');

const app = express();
const PORT = 3000;

app.use(cors());
app.use(express.json());

let channel, connection;

async function connectRabbitMQ() {
    try {
        // Replace 'rabbitmq' with your RabbitMQ hostname or IP, default guest/guest credentials
        connection = await amqp.connect('amqp://admin:adminRabbit@rabbitmq:5672');
        channel = await connection.createChannel();
        await channel.assertQueue('contact_messages', { durable: true });
        console.log('Connected to RabbitMQ');
    } catch (error) {
        console.error('Failed to connect to RabbitMQ', error);
    }
}

app.post('/send-to-rabbitmq', async (req, res) => {
    try {
        const message = req.body;
        if (!message.name || !message.email || !message.message) {
            return res.status(400).json({ error: 'Missing required fields' });
        }
        const sent = channel.sendToQueue('contact_messages', Buffer.from(JSON.stringify(message)), {
            persistent: true,
        });

        if (sent) {
            return res.json({ status: 'Message sent to queue' });
        } else {
            throw new Error('Failed to send message to queue');
        }
    } catch (error) {
        console.error('Error publishing message', error);
        return res.status(500).json({ error: 'Internal Server Error' });
    }
});

app.listen(PORT, () => {
    console.log(`Server listening on http://localhost:${PORT}`);
    connectRabbitMQ();
});
