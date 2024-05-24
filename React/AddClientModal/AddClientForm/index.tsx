import { useMemo } from 'react';
import { useTranslation } from 'react-i18next';
import { InputType } from '../../../../shared/components/atoms/input';
import { FormFieldKeys, useAddClient, useCurrencies, useClientData } from '../hooks';
import { AddClientFormProps } from './types';
import { useGlobalModalContext } from '../../../../shared/components/organismes/GlobalModal';
import Button, { Type as buttonType } from '../../../../shared/components/atoms/button';
import ButtonWithLoader from '../../../../shared/components/molecules/ButtonWithLoader';
import Alert from '../../../../shared/components/atoms/alert';
import { useDropdownCompanies } from '../../../organismes/ClientsTable/hooks';
import { FilterDropdownSelector } from '../../../../shared/components/molecules/FilterDropdownSelector';
import { InputWithValidation } from '../../../../shared/components/atoms/InputWithValidation';
import { TextAreaWithValidation } from '../../EditClientModal/EditClientForm/TextAreaWithValidation';
import { CurrencyDropdownMenuWithValidation } from '../../EditClientModal/EditClientForm/CurrencyDropdownMenuWithValidation';

export const AddClientForm = ({ fetchClients }: AddClientFormProps) => {
	const [t] = useTranslation('common');
	const { hideModal } = useGlobalModalContext();

	const {
		parentCompanies,
		loadingParentCompanies,
		showEnterSearchValueText,
		handleSearchChange,
	} = useDropdownCompanies();
	const { loadingCurrencies } = useCurrencies();
	const {
		selectedCompany,
		control,
		errors,
		handleCompanyClick,
		handleCurrencyClick,
		handleSubmit,
	} = useClientData();
	const { loadingAddClientInformation, serverError, handleAddClientClick } =
		useAddClient(fetchClients);

	const leftSideInputs = useMemo(() => {
		return [
			{
				name: 'firstName' as FormFieldKeys,
				label: t('CLIENTS.FIRST_NAME'),
				isRequired: true,
				isCritical: !!errors.firstName,
			},
			{
				name: 'email' as FormFieldKeys,
				label: t('SHARED.EMAIL'),
				isRequired: true,
				isCritical: !!errors.email,
			},
			{
				name: 'address1' as FormFieldKeys,
				label: t('CLIENTS.ADDRESS1'),
				isRequired: false,
			},
			{
				name: 'city' as FormFieldKeys,
				label: t('CLIENTS.CITY'),
				isRequired: false,
			},
			{
				name: 'state' as FormFieldKeys,
				label: t('CLIENTS.STATE'),
				isRequired: false,
			},
		];
	}, [errors?.firstName, errors?.email]);

	const rightSideInputs = useMemo(() => {
		return [
			{
				name: 'lastName' as FormFieldKeys,
				label: t('CLIENTS.LAST_NAME'),
				isRequired: true,
				isCritical: !!errors.lastName,
			},
			{
				name: 'phone' as FormFieldKeys,
				label: t('CLIENTS.PHONE'),
				isRequired: false,
				type: 'number' as InputType,
			},
			{
				name: 'address2' as FormFieldKeys,
				label: t('CLIENTS.ADDRESS2'),
				isRequired: false,
			},
			{
				name: 'zip' as FormFieldKeys,
				label: t('CLIENTS.ZIP'),
				isRequired: false,
			},
			{
				name: 'country' as FormFieldKeys,
				label: t('SHARED.COUNTRY'),
				isRequired: false,
			},
		];
	}, [errors?.lastName]);

	return (
		<div className='mt-6'>
			<form className='flex flex-wrap gap-6 md:flex-nowrap'>
				<div className='w-full'>
					<FilterDropdownSelector
						options={parentCompanies}
						selectedOption={selectedCompany}
						dropdownLabel={t('SHARED.COMPANY')}
						defaultOptionLabel={t('CLIENTS.OPTIONAL')}
						isLoading={loadingParentCompanies}
						showEnterSearchValueText={showEnterSearchValueText}
						containerClassName={'!w-full'}
						onSearchChange={handleSearchChange}
						onOptionClick={(option) => handleCompanyClick(option)}
						getOptionLabel={(option) => option?.Name || option?.CompanyName || ''}
						getOptionKey={(option) => option?.CompanyID}
					/>
					<InputWithValidation
						name='companyName'
						label={t('SHARED.NAME')}
						control={control}
						isLoading={false}
						isRequired
						isCritical={!!errors.companyName}
					/>
					<CurrencyDropdownMenuWithValidation
						name='currency'
						control={control}
						loadingCurrencies={loadingCurrencies}
						isRequired
						isCritical={!!errors.currency}
						containerClassName='w-full mt-[12px]'
						onCurrencyClick={handleCurrencyClick}
					/>
					<div className='flex flex-wrap gap-0 md:gap-4 md:flex-nowrap'>
						<div className='w-full'>
							{leftSideInputs.map((input) => (
								<InputWithValidation
									key={input.label}
									control={control}
									isLoading={false}
									{...input}
								/>
							))}
						</div>
						<div className='w-full'>
							{rightSideInputs.map((input) => (
								<InputWithValidation
									key={input.label}
									control={control}
									isLoading={false}
									{...input}
								/>
							))}
						</div>
					</div>
				</div>
				<div className='w-full'>
					<TextAreaWithValidation
						name='note'
						label={t('SHARED.NOTE')}
						control={control}
						isLoading={false}
						isRequired={false}
					/>
				</div>
			</form>
			<div className='h-[50px] mt-6'>
				{serverError ? <Alert text={serverError} /> : null}
			</div>
			<div className='flex justify-center gap-4 mt-6'>
				<Button type={buttonType.LINK} onClick={hideModal} content={t('BUTTON.CANCEL')} />
				<ButtonWithLoader
					className='w-[115px]'
					isLoading={loadingAddClientInformation}
					notLoadingContent={t('BUTTON.SUBMIT')}
					onClick={handleSubmit((formData) =>
						handleAddClientClick(selectedCompany, formData)
					)}
				/>
			</div>
		</div>
	);
};
