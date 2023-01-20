import React, { ChangeEvent, memo, useEffect, useState } from 'react';
import clsx from 'clsx';
import styles from './styles.module.scss';

type Props = {
	title: string;
	placeholder: string;
	maxValue: number;
	hasCardInformation: boolean;
	error?: string;
	uppercase?: boolean;
	onCardInformationChange: (value: string) => void;
};

export const TextInput = memo(
	({
		title,
		placeholder,
		maxValue,
		hasCardInformation,
		error,
		uppercase,
		onCardInformationChange,
	}: Props) => {
		const [currentValue, setCurrentValue] = useState('');

		const inputClass = clsx(
			styles.input,
			error && styles.inputWithError,
			uppercase && styles.inputWithUppercase
		);

		useEffect(() => {
			// clean state after submitting form
			if (!hasCardInformation) setCurrentValue('');
		}, [hasCardInformation]);

		const onChange = (e: ChangeEvent<HTMLInputElement>) => {
			const value = e.currentTarget.value;

			if (value.length <= maxValue) {
				setCurrentValue(value);
				onCardInformationChange(value);
			}
		};

		return (
			<div className={styles.container}>
				<p className={styles.title}>{title}</p>
				<input
					className={inputClass}
					placeholder={placeholder}
					value={currentValue}
					onChange={onChange}
				/>
				{error && <p className={styles.error}>{error}</p>}
			</div>
		);
	}
);
