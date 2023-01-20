import React, { memo, useMemo } from 'react';
import { useTranslation } from 'react-i18next';
import { CardField } from 'service/profile/models';
import { Errors } from '../../../../../../types';
import { countries, USAStates } from 'utils/countries';
import {
	MAX_CARD_CITY_LENGTH,
	MAX_CARD_ADDRESS_LENGTH,
	MAX_CARD_POSTAL_CODE_LENGTH,
} from '../../../../../../helpers';
import { DropdownInput } from '../DropdownInput';
import { TextInput } from '../TextInput';

type Props = {
	hasCardInformation: boolean;
	errors: Errors;
	showErrors: boolean;
	onCardInformationChange: (field: CardField, value: string) => void;
};

export const PersonalInformationInputs = memo(
	({ hasCardInformation, errors, showErrors, onCardInformationChange }: Props) => {
		const { t } = useTranslation();

		const countryOptions = useMemo(() => countries, []);
		const stateOptions = useMemo(() => USAStates, []);

		const dropdownInputs = useMemo(() => {
			return [
				{
					options: countryOptions,
					title: t('billing_page_add_card_section_card_country_title'),
					placeholder: t('billing_page_add_card_section_card_country_placeholder'),
					hasCardInformation,
					error: showErrors ? errors.country : '',
					onCardInformationClick: (value: string) =>
						onCardInformationChange('country', value),
				},
				{
					options: stateOptions,
					title: t('billing_page_add_card_section_card_state_title'),
					placeholder: t('billing_page_add_card_section_card_state_placeholder'),
					hasCardInformation,
					error: showErrors ? errors.state : '',
					onCardInformationClick: (value: string) =>
						onCardInformationChange('state', value),
				},
			];
		}, [
			countryOptions,
			errors.country,
			errors.state,
			hasCardInformation,
			onCardInformationChange,
			showErrors,
			stateOptions,
			t,
		]);

		const textInputs = useMemo(() => {
			return [
				{
					title: t('billing_page_add_card_section_card_city_title'),
					placeholder: t('billing_page_add_card_section_card_city_placeholder'),
					maxValue: MAX_CARD_CITY_LENGTH,
					hasCardInformation,
					error: showErrors ? errors.city : '',
					onCardInformationChange: (value: string) =>
						onCardInformationChange('city', value),
				},
				{
					title: t('billing_page_add_card_section_card_first_address_title'),
					placeholder: t('billing_page_add_card_section_card_first_address_placeholder'),
					maxValue: MAX_CARD_ADDRESS_LENGTH,
					hasCardInformation,
					error: showErrors ? errors.address : '',
					onCardInformationChange: (value: string) =>
						onCardInformationChange('address', value),
				},
				{
					title: t('billing_page_add_card_section_card_second_address_title'),
					placeholder: t('billing_page_add_card_section_card_second_address_placeholder'),
					maxValue: MAX_CARD_ADDRESS_LENGTH,
					hasCardInformation,
					error: '',
					onCardInformationChange: (value: string) =>
						onCardInformationChange('secondAddress', value),
				},
				{
					title: t('billing_page_add_card_section_card_postal_code_title'),
					placeholder: t('billing_page_add_card_section_card_postal_code_placeholder'),
					maxValue: MAX_CARD_POSTAL_CODE_LENGTH,
					hasCardInformation,
					error: showErrors ? errors.postalCode : '',
					uppercase: true,
					onCardInformationChange: (value: string) =>
						onCardInformationChange('postalCode', value),
				},
			];
		}, [
			t,
			hasCardInformation,
			showErrors,
			errors.city,
			errors.address,
			errors.postalCode,
			onCardInformationChange,
		]);

		return (
			<>
				{dropdownInputs.map((input) => {
					return <DropdownInput key={input.title} {...input} />;
				})}
				{textInputs.map((input) => {
					return <TextInput key={input.title} {...input} />;
				})}
			</>
		);
	}
);
