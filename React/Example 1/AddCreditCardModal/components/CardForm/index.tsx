import React, { memo, useCallback } from 'react';
import { useTranslation } from 'react-i18next';
import { CardField } from 'service/profile/models';
import { Errors } from '../../../../../../types';
import { useDebounceCallback } from 'hooks';
import { MAX_CARD_NAME_LENGTH } from '../../../../../../helpers';
import { CardNumberInput } from '../CardNumberInput';
import { CardExpiryInput } from '../CardExpiryInput';
import { CardCvvInput } from '../CardCvvInput';
import { TextInput } from '../TextInput';
import { PersonalInformationInputs } from '../PersonalInformationInputs';
import { ActionButtons } from '../ActionButtons';
import styles from './styles.module.scss';

type Props = {
	hasCardInformation: boolean;
	disabled: boolean;
	errors: Errors;
	showErrors: boolean;
	loadingCard: boolean;
	onCardInformationChange: (field: CardField, value: string) => void;
	onCancelClick: () => void;
	onSaveClick: () => void;
};

export const CardForm = memo(
	({
		hasCardInformation,
		disabled,
		errors,
		showErrors,
		loadingCard,
		onCardInformationChange,
		onCancelClick,
		onSaveClick,
	}: Props) => {
		const { t } = useTranslation();

		const debouncedCardInformationChange = useDebounceCallback(
			(field: CardField, value: string) => onCardInformationChange(field, value),
			200
		);

		const handleCardNameChange = useCallback(
			(value: string) => {
				debouncedCardInformationChange('name', value);
			},
			[debouncedCardInformationChange]
		);

		return (
			<div className={styles.container}>
				<div className={styles.cardInformationContainer}>
					<CardNumberInput
						title={t('billing_page_add_card_section_card_number_title')}
						placeholder={t('billing_page_add_card_section_card_number_placeholder')}
						hasCardInformation={hasCardInformation}
						error={showErrors ? errors.number : ''}
						onCardInformationChange={debouncedCardInformationChange}
					/>
					<div className={styles.cardInformationWrapper}>
						<CardExpiryInput
							title={t('billing_page_add_card_section_card_expiry_title')}
							placeholder={t('billing_page_add_card_section_card_expiry_placeholder')}
							hasCardInformation={hasCardInformation}
							error={showErrors ? errors.expiry : ''}
							onCardInformationChange={debouncedCardInformationChange}
						/>
						<CardCvvInput
							title={t('billing_page_add_card_section_card_cvv_title')}
							placeholder={t('billing_page_add_card_section_card_cvv_placeholder')}
							hasCardInformation={hasCardInformation}
							error={showErrors ? errors.cvv : ''}
							onCardInformationChange={debouncedCardInformationChange}
						/>
					</div>
					<TextInput
						title={t('billing_page_add_card_section_card_name_title')}
						placeholder={t('billing_page_add_card_section_card_name_placeholder')}
						maxValue={MAX_CARD_NAME_LENGTH}
						hasCardInformation={hasCardInformation}
						error={showErrors ? errors.name : ''}
						onCardInformationChange={handleCardNameChange}
					/>
				</div>
				<div className={styles.personalInformationContainer}>
					<PersonalInformationInputs
						hasCardInformation={hasCardInformation}
						errors={errors}
						showErrors={showErrors}
						onCardInformationChange={debouncedCardInformationChange}
					/>
					<ActionButtons
						disabled={disabled}
						loadingCard={loadingCard}
						onCancelClick={onCancelClick}
						onSaveClick={onSaveClick}
					/>
				</div>
			</div>
		);
	}
);
