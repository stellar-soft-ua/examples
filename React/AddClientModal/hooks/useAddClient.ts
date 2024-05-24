import { AxiosResponse } from 'axios'
import { useState, useCallback } from 'react'
import { useTranslation } from 'react-i18next'
import { FormFields } from '.'
import { useGlobalModalContext } from '../../../../shared/components/organismes/GlobalModal'
import { useGlobalNotificationContext } from '../../../../shared/components/organismes/GlobalNotification'
import { useAppDispatch, useAppSelector } from '../../../../store'
import { Type as NotificationTypes } from '../../../../shared/components/atoms/Notification'
import { addClient } from '../../../../service/clients'
import { AddClientDto } from '../../../../service/clients/dtos'
import { ParentCompany } from '../../../../service/clients/models'

export const useAddClient = (fetchClients: () => void) => {
  const [serverError, setServerError] = useState('')

  const [t] = useTranslation('common')
  const { hideModal } = useGlobalModalContext()
  const { showNotification } = useGlobalNotificationContext()

  const dispatch = useAppDispatch()
  const loadingAddClientInformation = useAppSelector((state) => state.clients.loadingAddClient)

  const onSuccessCallback = useCallback((response: AxiosResponse) => {
    if (response?.data?.Good) {
      hideModal()
      showNotification({
        text: t('SHARED.SUCCESSFULLY_ADDED'),
        type: NotificationTypes.SUCCESS,
      })
      fetchClients()
    } else {
      setServerError(response?.data?.ErrorMessage)
    }
  }, [hideModal, showNotification, fetchClients, serverError, t]);

  const handleAddClientClick = useCallback((selectedCompany: ParentCompany | null, formData: FormFields) => {
    const dto: AddClientDto = {
      Name: formData.companyName,
      Currency: formData.currency,
      FirstName: formData.firstName,
      LastName: formData.lastName,
      Email: formData.email,
      CompanyID: selectedCompany.CompanyID,
      Address1: formData.address1,
      Address2: formData.address2,
      AdminNote: formData.note,
      City: formData.city,
      CountryIso: formData.country,
      Phone: Number(formData.phone),
      State: formData.state,
      ZipCode: formData.zip,
      onSuccessCallback,
    }

    dispatch(addClient(dto))
  }, [dispatch]);

  return { loadingAddClientInformation, serverError, handleAddClientClick }
}
