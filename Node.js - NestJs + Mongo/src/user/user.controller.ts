import { Body, Controller, Delete, Get, Param, Post } from '@nestjs/common';
import { Observable } from 'rxjs';
import { MailerService } from '@nestjs-modules/mailer';
import { ConfigService } from '@nestjs/config';
import { UserDto } from '../dto/user';
import { UserService } from './user.service';
import { MqService } from '../mq/mq.service';
import { UserEntity } from '../db/user.model';

@Controller('user')
export class UserController {
  constructor(
    private readonly userService: UserService,
    private readonly mailerService: MailerService,
    private configService: ConfigService,
    private mqService: MqService,
  ) {}

  @Get(':userId')
  getUserById(@Param('userId') id: number): Observable<UserDto> {
    return this.userService.getUserById(id);
  }

  @Get(':userId/avatar')
  getAvatar(@Param('userId') id: string): Observable<string> {
    return this.userService.getAvatar(id);
  }

  @Post()
  async createUser(@Body() userDto: UserDto): Promise<UserEntity> {
    const user = await this.userService.createUser(userDto);

    await Promise.all([
      this.mqService.sendMessage('user', `[${user.email}] created`),
      this.mailerService.sendMail({
        to: this.configService.get<string>('WATCHER_MAIL'),
        text: `Hello Watcher, a user [${user.email}] has been created!`,
        subject: 'New User!',
      }),
    ]);

    return user;
  }

  @Delete(':userId/avatar')
  async deleteAvatar(
    @Param('userId') id: string,
  ): Promise<{ message: string }> {
    await this.userService.removeAvatar(id);
    return { message: 'Avatar deleted successfully' };
  }
}
