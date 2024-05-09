import { of, tap } from 'rxjs';
import { Test, TestingModule } from '@nestjs/testing';
import { MailerService } from '@nestjs-modules/mailer';
import { ConfigService } from '@nestjs/config';
import { UserController } from './user.controller';
import { UserService } from './user.service';
import { MqService } from '../mq/mq.service';
import { UserDto } from '../dto/user';
import { UserEntity } from '../db/user.model';
import { mockDeep } from 'jest-mock-extended';

describe('UserController', () => {
  let controller: UserController;
  const mqService = mockDeep<MqService>();
  const mailerService = mockDeep<MailerService>();
  const userService = mockDeep<UserService>();

  beforeEach(async () => {
    const module: TestingModule = await Test.createTestingModule({
      providers: [
        ConfigService,
        {
          provide: MqService,
          useValue: mqService,
        },
        {
          provide: MailerService,
          useValue: mailerService,
        },
        {
          provide: UserService,
          useValue: userService,
        },
      ],
      controllers: [UserController],
    }).compile();

    controller = module.get<UserController>(UserController);
  });

  it('should be defined', () => {
    expect(controller).toBeDefined();
  });

  describe('getUserById', () => {
    it('should return a user', () => {
      const userId = 1;
      const userDto = new UserDto();
      jest
        .spyOn(userService, 'getUserById')
        .mockImplementation(() => of(userDto));

      controller
        .getUserById(userId)
        .pipe(tap((result) => expect(result).toBe(userDto)));
    });
  });

  describe('getAvatar', () => {
    it('should return an avatar', async () => {
      const userId = '1';
      const avatar = 'avatar-url';
      jest.spyOn(userService, 'getAvatar').mockImplementation(() => of(avatar));

      controller
        .getAvatar(userId)
        .pipe(tap((result) => expect(result).toBe(avatar)));
    });
  });

  describe('createUser', () => {
    it('should create a user', async () => {
      const userDto = new UserDto();
      const userEntity = {} as UserEntity;
      jest
        .spyOn(userService, 'createUser')
        .mockImplementation(() => Promise.resolve(userEntity));
      jest
        .spyOn(mqService, 'sendMessage')
        .mockImplementation(() => Promise.resolve());
      jest
        .spyOn(mailerService, 'sendMail')
        .mockImplementation(() => Promise.resolve());

      expect(await controller.createUser(userDto)).toBe(userEntity);
      expect(mailerService.sendMail).toHaveBeenCalled();
      expect(mqService.sendMessage).toHaveBeenCalled();
      expect(userService.createUser).toHaveBeenCalled();
    });
  });

  describe('deleteAvatar', () => {
    it('should delete the avatar', async () => {
      const userId = '1';
      jest
        .spyOn(userService, 'removeAvatar')
        .mockImplementation(() => Promise.resolve());

      expect(await controller.deleteAvatar(userId)).toEqual({
        message: 'Avatar deleted successfully',
      });
      expect(userService.removeAvatar).toHaveBeenCalled();
    });
  });
});
