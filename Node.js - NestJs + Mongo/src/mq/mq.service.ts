import { Injectable } from '@nestjs/common';
import * as amqp from 'amqplib';

@Injectable()
export class MqService {
  private connection: amqp.Connection;
  private channel: amqp.Channel;

  async initialize(): Promise<void> {
    this.connection = await amqp.connect(process.env.RABBITMQ_URL);
    this.channel = await this.connection.createChannel();
  }

  async sendMessage(queueName: string, message: any): Promise<void> {
    await this.channel.assertQueue(queueName);
    await this.channel.sendToQueue(
      queueName,
      Buffer.from(JSON.stringify(message)),
    );
  }
}
