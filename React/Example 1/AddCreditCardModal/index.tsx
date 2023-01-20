import React, { memo, useCallback, useEffect, useState } from 'react';
import { useTranslation } from 'react-i18next';
import clsx from 'clsx';
import { Card, CardField } from 'service/profile/models';
import { Errors } from '../../../../types';
import { validateCardInformation } from '../../../../utils';
import { initialCardInformation } from '../../../../helpers';
import ReactPortal from 'components/common/general/ReactPortal';
import { GoBackIcon } from 'images/mobile/common';
import { CardForm } from './components/CardForm';
import styles from './styles.module.scss';

type Props = {
	show: boolean;
	loadingCard: boolean;
	savedCardInformation: boolean;
	onBackClick: () => void;
	onSaveCardClick: (card: Card) => void;
};

export const AddCreditCardModal = memo(
	({ show, loadingCard, savedCardInformation, onBackClick, onSaveCardClick }: Props) => {
		const [cardInformation, setCardInformation] = useState<Card>(initialCardInformation);
		const [errors, setErrors] = useState<Errors>({});
		const [showErrors, setShowErrors] = useState(false);

		const { t } = useTranslation();

		const hasCardInformation = Boolean(
			Object.values(cardInformation).find((value) => value)
		);
		const hasErrors = Object.values(errors).length > 0;
		const disabled = hasErrors && showErrors;

		const containerClass = clsx(
			styles.container,
			show ? styles.openedContainer : styles.closedContainer
		);

		useEffect(() => {
			// validate card information
			setShowErrors(false);
			setErrors(validateCardInformation(cardInformation, t));
		}, [cardInformation, t]);

		useEffect(() => {
			// close modal after successful card saving
			if (savedCardInformation) {
				onBackClick();
				setCardInformation(initialCardInformation);
			}
		}, [savedCardInformation, onBackClick]);

		const handleCardInformationChange = useCallback(
			// save card information
			(field: CardField, value: string) => {
				setCardInformation({
					...cardInformation,
					[field]: value,
				});
			},
			[cardInformation]
		);

		const handleBackClick = useCallback(() => {
			onBackClick();
			setCardInformation(initialCardInformation);
		}, [onBackClick]);

		const handleSaveCardClick = useCallback(() => {
			// submit card information
			if (hasErrors) {
				setShowErrors(true);
				return;
			}
			onSaveCardClick(cardInformation);
		}, [cardInformation, hasErrors, onSaveCardClick]);

		return (
			<ReactPortal wrapperId='add-card-modal'>
				<div className={containerClass}>
					<div className={styles.headerSection} onClick={handleBackClick}>
						<GoBackIcon />
						<p className={styles.title}>{t('billing_page_payment_methods_title')}</p>
					</div>
					<CardForm
						hasCardInformation={hasCardInformation}
						disabled={disabled}
						errors={errors}
						showErrors={showErrors}
						loadingCard={loadingCard}
						onCardInformationChange={handleCardInformationChange}
						onCancelClick={handleBackClick}
						onSaveClick={handleSaveCardClick}
					/>
				</div>
			</ReactPortal>
		);
	}
);
