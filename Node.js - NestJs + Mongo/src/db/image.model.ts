import { Prop, Schema, SchemaFactory } from '@nestjs/mongoose';
import { Document } from 'mongoose';

@Schema()
export class ImageEntity extends Document {
  @Prop({ required: true })
  userId: string;

  @Prop({ required: true })
  path: string;
}

export const ImageEntitySchema = SchemaFactory.createForClass(ImageEntity);
