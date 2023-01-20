import React, { ChangeEvent, memo, useEffect, useState } from 'react';
import clsx from 'clsx';
import { CardField } from 'service/profile/models';
import { MAX_CARD_NUMBER_LENGTH } from '../../../../../../helpers';
import { getCardType } from '../../../../../../utils';
import { CardIcon } from '../CardIcon';
import styles from './styles.module.scss';

type Props = {
	title: string;
	placeholder: string;
	hasCardInformation: boolean;
	error?: string;
	onCardInformationChange: (field: CardField, number: string) => void;
};

export const CardNumberInput = memo(
	({ title, placeholder, hasCardInformation, error, onCardInformationChange }: Props) => {
		const [cardNumber, setCardNumber] = useState('');

		const cardType = getCardType(cardNumber.split(' ').join(''));

		const inputClass = clsx(
			styles.input,
			error && styles.inputWithError,
			cardType ? styles.inputWithCardIcon : styles.inputWithoutCardIcon
		);

		useEffect(() => {
			// clean state after submitting form
			if (!hasCardInformation) setCardNumber('');
		}, [hasCardInformation]);

		const onChange = (e: ChangeEvent<HTMLInputElement>) => {
			const formattedValue = e.currentTarget.value // add space after every 4 characters
				.replace(/[^\d]/g, '')
				.replace(/(.{4})/g, '$1 ')
				.trim();

			if (formattedValue.length <= MAX_CARD_NUMBER_LENGTH) {
				setCardNumber(formattedValue);
				onCardInformationChange('number', formattedValue);
			}
		};

		return (
			<div className={styles.container}>
				<p className={styles.title}>{title}</p>
				<CardIcon cardType={cardType} />
				<input
					className={inputClass}
					type='tel'
					placeholder={placeholder}
					value={cardNumber}
					onChange={onChange}
				/>
				{error && <p className={styles.error}>{error}</p>}
			</div>
		);
	}
);
