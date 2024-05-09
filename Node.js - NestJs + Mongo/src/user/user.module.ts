import { Module } from '@nestjs/common';
import { UserController } from './user.controller';
import { UserService } from './user.service';
import { HttpModule } from '@nestjs/axios';
import { MongooseModule } from '@nestjs/mongoose';
import { ImageEntitySchema, ImageEntity } from 'src/db/image.model';
import { UserEntity, UserEntitySchema } from 'src/db/user.model';
import { MqService } from 'src/mq/mq.service';

@Module({
  imports: [
    HttpModule,
    MongooseModule.forFeature([
      { name: UserEntity.name, schema: UserEntitySchema },
      { name: ImageEntity.name, schema: ImageEntitySchema },
    ]),
  ],
  controllers: [UserController],
  providers: [UserService, MqService],
})
export class UserModule {}
