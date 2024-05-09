import { Module } from '@nestjs/common';
import { UserModule } from './user/user.module';
import { DbModule } from './db/db.module';
import { MailerModule } from '@nestjs-modules/mailer';
import { ConfigModule, ConfigService } from '@nestjs/config';

@Module({
  imports: [
    ConfigModule.forRoot({
      isGlobal: true,
    }),
    MailerModule.forRootAsync({
      imports: [ConfigModule],
      useFactory: async (configService: ConfigService) => ({
        transport: {
          host: configService.get('MAILER_TRANSPORT_HOST'),
          port: configService.get('MAILER_TRANSPORT_PORT', 587),
          secure: configService.get('MAILER_TRANSPORT_SECURE', false),
          auth: {
            user: configService.get('MAILER_TRANSPORT_AUTH_USER'),
            pass: configService.get('MAILER_TRANSPORT_AUTH_PASS'),
          },
        },
      }),
      inject: [ConfigService],
    }),
    DbModule,
    UserModule,
  ],
})
export class AppModule {}
