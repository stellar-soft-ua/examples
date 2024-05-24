import { useState, useCallback } from 'react'
import { useForm } from 'react-hook-form'
import { ParentCompany } from '../../../../service/clients/models'

export type FormFields = {
  companyName: string
  currency: string
  firstName: string
  lastName: string
  email: string
  phone: string
  address1: string
  address2: string
  city: string
  zip: string
  state: string
  country: string
  note: string
}

export type FormFieldKeys = keyof FormFields

export const useClientData = () => {
  const [selectedCompany, setSelectedCompany] = useState<ParentCompany | null>(null)

  const {
    control,
    setValue,
    handleSubmit,
    formState: { errors },
  } = useForm<FormFields>({
    defaultValues: {
      companyName: '',
      currency: '',
      firstName: '',
      lastName: '',
      email: '',
      phone: '',
      address1: '',
      address2: '',
      city: '',
      zip: '',
      state: '',
      country: '',
      note: '',
    },
  })

  const handleCompanyClick = useCallback((company: ParentCompany | null) => {
    setSelectedCompany(company)
  }, [setSelectedCompany]);

  const handleCurrencyClick = useCallback((currency: string) => {
    setValue('currency', currency)
  }, [setValue]);

  return {
    selectedCompany,
    control,
    errors,
    handleCompanyClick,
    handleCurrencyClick,
    handleSubmit,
  }
}
