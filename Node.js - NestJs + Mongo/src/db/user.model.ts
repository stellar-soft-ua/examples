import mongoose, { Document } from 'mongoose';
import { Prop, Schema, SchemaFactory } from '@nestjs/mongoose';

@Schema()
export class UserEntity extends Document {
  @Prop({ type: mongoose.Schema.Types.ObjectId })
  id: number;

  @Prop({ required: true })
  email: string;

  @Prop({ required: true })
  first_name: string;

  @Prop({ required: true })
  last_name: string;

  @Prop({ required: true })
  avatar: string;
}

export const UserEntitySchema = SchemaFactory.createForClass(UserEntity);
