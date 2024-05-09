import { HttpService } from '@nestjs/axios';
import { Injectable, NotFoundException } from '@nestjs/common';
import { ConfigService } from '@nestjs/config';
import { InjectModel } from '@nestjs/mongoose';
import { AxiosResponse } from 'axios';
import { writeFile, readFile, unlink } from 'fs/promises';
import { ensureDir } from 'fs-extra';
import { Model } from 'mongoose';
import { join } from 'path';
import { Observable, concatMap, from, map } from 'rxjs';
import { ImageEntity } from '../db/image.model';
import { UserEntity } from '../db/user.model';
import { UserDto } from '../dto/user';
import { v4 as uuidv4 } from 'uuid';

@Injectable()
export class UserService {
  private readonly apiUrl: string;

  constructor(
    @InjectModel(ImageEntity.name) private imageModel: Model<ImageEntity>,
    @InjectModel(UserEntity.name) private userModel: Model<UserEntity>,
    private httpService: HttpService,
    private configService: ConfigService,
  ) {
    this.apiUrl = this.configService.get<string>('API_URL');
  }

  getUserById(id: number | string): Observable<UserDto> {
    const apiUrl = `${this.apiUrl}/users/${id}`;
    return this.httpService
      .get(apiUrl)
      .pipe(
        map((response: AxiosResponse<{ data: UserDto }>) => response.data.data),
      );
  }

  getAvatar(userId: string) {
    return from(this.findUserAvatar(userId)).pipe(
      concatMap((avatarDetails) => {
        if (avatarDetails) {
          return from(readFile(avatarDetails.path, { encoding: 'base64' }));
        }
        return this.loadUserAvatar(userId);
      }),
    );
  }

  async createUser(userDto: UserDto): Promise<UserEntity> {
    return this.userModel.create(userDto);
  }

  async removeAvatar(userId: string) {
    const image = await this.findUserAvatar(userId);

    if (!image) {
      throw new NotFoundException('Avatar not found');
    }

    return void Promise.all([
      unlink(image.path),
      this.imageModel.findOneAndDelete({ userId, path: image.path }),
    ]);
  }

  loadUserAvatar(userId: string) {
    return this.getUserById(userId).pipe(
      concatMap((user: UserDto) =>
        this.httpService.get(user.avatar, { responseType: 'arraybuffer' }),
      ),
      concatMap((response) => {
        const hash = uuidv4();
        const imageFileName = `${userId}_${hash}`;
        const directory = join(__dirname, 'avatars');
        const imagePath = join(directory, imageFileName);

        return from(ensureDir(directory)).pipe(
          concatMap(() => from(writeFile(imagePath, response.data))),
          concatMap(() => from(this.saveUserAvatar(userId, imagePath))),
          map(() => Buffer.from(response.data, 'binary').toString('base64')),
        );
      }),
    );
  }

  async findUserAvatar(userId: string): Promise<ImageEntity | null> {
    return this.imageModel.findOne({ userId });
  }

  async saveUserAvatar(userId: string, path: string): Promise<ImageEntity> {
    return this.imageModel.create({ userId, path });
  }
}
