public class ItemEstoque
    {
        public int Id { get; set; }
        public string Nome { get; set; }
        public int Quantidade { get; set; }
    }

    public class EstoqueService
    {
        private List<ItemEstoque> _itens = new List<ItemEstoque>();

        public void Inserir(ItemEstoque item) => _itens.Add(item);

        public void BaixaEstoque(int id, int qtd)
        {
            var item = _itens.FirstOrDefault(i => i.Id == id);
            if (item != null)
            {
                // Desafio: Impedir estoque negativo
                if (item.Quantidade - qtd < 0)
                    Console.WriteLine($"Erro: Estoque insuficiente para {item.Nome}.");
                else
                    item.Quantidade -= qtd;
            }
        }

        public List<ItemEstoque> ListarEstoqueBaixo(int limite) 
            => _itens.Where(i => i.Quantidade < limite).ToList();
    }
