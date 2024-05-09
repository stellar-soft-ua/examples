import { of, tap } from 'rxjs';
import { getModelToken } from '@nestjs/mongoose';
import { Test, TestingModule } from '@nestjs/testing';
import { ConfigService } from '@nestjs/config';
import { UserService } from './user.service';
import { UserDto } from '../dto/user';
import { ImageEntity } from '../db/image.model';
import { UserEntity } from '../db/user.model';
import { HttpModule, HttpService } from '@nestjs/axios';
import { mockDeep } from 'jest-mock-extended';
import { Model } from 'mongoose';
import { AxiosResponse } from 'axios';
import { NotFoundException } from '@nestjs/common';
import * as fs from 'fs/promises';

describe('UserService', () => {
  let httpService: HttpService;
  let userService: UserService;
  let mockImageModel: Model<ImageEntity>;
  let mockUserModel: Model<UserEntity>;

  const mockUserDto: UserDto = {
    email: 'email@email.com',
    first_name: 'first_name',
    last_name: 'last_name',
    avatar: 'https://avatar.jpg',
  };

  beforeEach(async () => {
    jest.clearAllMocks();

    mockImageModel = mockDeep<Model<ImageEntity>>();
    mockUserModel = mockDeep<Model<UserEntity>>();

    const module: TestingModule = await Test.createTestingModule({
      imports: [HttpModule],
      providers: [
        ConfigService,
        {
          provide: getModelToken(ImageEntity.name),
          useValue: mockImageModel,
        },
        {
          provide: getModelToken(UserEntity.name),
          useValue: mockUserModel,
        },
        UserService,
      ],
    }).compile();

    userService = module.get<UserService>(UserService);
    httpService = module.get<HttpService>(HttpService);

    jest.doMock('fs/promises', () => ({
      unlink: () => 'null',
      writeFile: () => 'null',
      readFile: () => 'null',
    }));

    jest.doMock('fs-extra', () => ({
      ensureDir: () => null,
    }));
  });

  describe('getUserById', () => {
    it('should return a user', () => {
      const userId = '1';

      const expectedResponse: AxiosResponse<{ data: UserDto }> = {
        data: { data: mockUserDto },
        status: 200,
        statusText: 'OK',
        headers: {},
        config: {} as any,
      };
      jest.spyOn(httpService, 'get').mockReturnValue(of(expectedResponse));

      userService.getUserById(userId).pipe(
        tap((result) => {
          expect(result).toEqual(mockUserDto);
          expect(httpService.get).toHaveBeenCalledWith(`/users/${userId}`);
        }),
      );
    });
  });

  describe('getAvatar', () => {
    it('should load avatar', () => {
      const userId = '1';
      jest.spyOn(userService, 'findUserAvatar').mockResolvedValue(null);
      jest
        .spyOn(userService, 'loadUserAvatar')
        .mockReturnValue(of('base64EncodedImage'));

      userService
        .getAvatar(userId)
        .pipe(tap((result) => expect(result).toEqual('base64EncodedImage')));
    });

    it('should return avatar', () => {
      const userId = '1';
      jest
        .spyOn(userService, 'findUserAvatar')
        .mockResolvedValue({ avatar: 'some-path' } as any);
      jest
        .spyOn(userService, 'loadUserAvatar')
        .mockReturnValue(of('base64EncodedImage'));
      jest.spyOn(fs, 'readFile').mockResolvedValue('base64EncodedImage');

      userService
        .getAvatar(userId)
        .pipe(tap((result) => expect(result).toEqual('base64EncodedImage')));
    });
  });

  describe('createUser', () => {
    it('should create a user', async () => {
      const newUser: UserEntity = { id: 1, ...mockUserDto } as UserEntity;
      jest.spyOn(mockUserModel, 'create').mockResolvedValue(newUser as any);

      const result = await userService.createUser(mockUserDto);

      expect(result).toEqual(newUser);
      expect(mockUserModel.create).toHaveBeenCalled();
    });
  });

  describe('removeAvatar', () => {
    it('should remove avatar', async () => {
      const userId = '1';
      const mockImage: ImageEntity = {
        userId,
        path: '/path/to/avatar',
      } as ImageEntity;
      jest.spyOn(userService, 'findUserAvatar').mockResolvedValue(mockImage);
      jest
        .spyOn(mockImageModel, 'findOneAndDelete')
        .mockResolvedValue(mockImage);
      jest.spyOn(fs, 'unlink').mockReturnValue(null);

      await userService.removeAvatar(userId);

      expect(userService.findUserAvatar).toHaveBeenCalled();
      expect(mockImageModel.findOneAndDelete).toHaveBeenCalled();
      expect(fs.unlink).toHaveBeenCalled();
    });

    it('should throw NotFoundException if avatar not found', async () => {
      const userId = '1';
      jest.spyOn(userService, 'findUserAvatar').mockResolvedValue(null);

      await expect(userService.removeAvatar(userId)).rejects.toThrow(
        NotFoundException,
      );
    });
  });
});
