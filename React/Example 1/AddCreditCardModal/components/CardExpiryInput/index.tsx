import React, { ChangeEvent, memo, useEffect, useState } from 'react';
import clsx from 'clsx';
import { CardField } from 'service/profile/models';
import { MAX_CARD_EXPIRY_LENGTH } from '../../../../../../helpers';
import styles from './styles.module.scss';

type Props = {
	title: string;
	placeholder: string;
	hasCardInformation: boolean;
	error?: string;
	onCardInformationChange: (field: CardField, expiry: string) => void;
};

export const CardExpiryInput = memo(
	({ title, placeholder, hasCardInformation, error, onCardInformationChange }: Props) => {
		const [cardExpiry, setCardExpiry] = useState('');

		const inputClass = clsx(styles.input, error && styles.inputWithError);

		useEffect(() => {
			// clean state after submitting form
			if (!hasCardInformation) setCardExpiry('');
		}, [hasCardInformation]);

		const onChange = (e: ChangeEvent<HTMLInputElement>) => {
			let value = e.currentTarget.value.replace(/[^\d]/g, '');
			const valueWithSpaces: Array<string> = [];

			while (value.length >= 2 && value.length <= MAX_CARD_EXPIRY_LENGTH) {
				// split entered value by 2 digits
				valueWithSpaces.push(value.substring(0, 2));
				value = value.substring(2);
			}
			if (value.length > 0) valueWithSpaces.push(value);

			const formattedValue = valueWithSpaces.join('/'); // join all values by /

			if (formattedValue.length <= MAX_CARD_EXPIRY_LENGTH) {
				setCardExpiry(formattedValue);
				onCardInformationChange('expireDate', formattedValue);
			}
		};

		return (
			<div className={styles.container}>
				<p className={styles.title}>{title}</p>
				<input
					className={inputClass}
					type='tel'
					placeholder={placeholder}
					value={cardExpiry}
					onChange={onChange}
				/>
				{error && <p className={styles.error}>{error}</p>}
			</div>
		);
	}
);
