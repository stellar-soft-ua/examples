import React, { ChangeEvent, memo, useEffect, useState } from 'react';
import clsx from 'clsx';
import { CardField } from 'service/profile/models';
import { MAX_CARD_CVV_LENGTH } from '../../../../../../helpers';
import styles from './styles.module.scss';

type Props = {
	title: string;
	placeholder: string;
	hasCardInformation: boolean;
	error?: string;
	onCardInformationChange: (field: CardField, cvv: string) => void;
};

export const CardCvvInput = memo(
	({ title, placeholder, hasCardInformation, error, onCardInformationChange }: Props) => {
		const [cardCvv, setCardCvv] = useState('');

		const inputClass = clsx(styles.input, error && styles.inputWithError);

		useEffect(() => {
			// clean state after submitting form
			if (!hasCardInformation) setCardCvv('');
		}, [hasCardInformation]);

		const onChange = (e: ChangeEvent<HTMLInputElement>) => {
			const value = e.currentTarget.value;

			if (value.length <= MAX_CARD_CVV_LENGTH) {
				setCardCvv(value);
				onCardInformationChange('cvv', value);
			}
		};

		return (
			<div className={styles.container}>
				<p className={styles.title}>{title}</p>
				<input
					className={inputClass}
					type='number'
					placeholder={placeholder}
					value={cardCvv}
					onChange={onChange}
				/>
				{error && <p className={styles.error}>{error}</p>}
			</div>
		);
	}
);
